<?php

namespace App\Filament\Admin\Pages;

use App\Models\User;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Mail;
use Webklex\PHPIMAP\ClientManager;

class Correo extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.admin.pages.correo';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'Bandeja de entrada';
    protected static ?string $title = 'Correo';
    protected static ?int $navigationSort = 20;
    protected static string|\UnitEnum|null $navigationGroup = 'Correo';

    public ?array $composeData = [];
    public array $messages = [];
    public ?string $connectionError = null;
    public bool $showCompose = false;

    public function mount(): void
    {
        $this->composeForm->fill();

        if (auth()->user()->hasMailConfigured()) {
            $this->loadInbox();
        }
    }

    protected function getForms(): array
    {
        return ['composeForm'];
    }

    public function composeForm(Schema $schema): Schema
    {
        return $schema
            ->statePath('composeData')
            ->components([
                TextInput::make('to')->label('Para')->email()->required(),
                TextInput::make('subject')->label('Asunto')->required(),
                RichEditor::make('body')->label('Mensaje')->required(),
                    
            ]);
    }

    public function loadInbox(): void
    {
        $user = auth()->user();

        if (! $user->hasMailConfigured()) {
            return;
        }

        try {
            $client = $this->makeImapClient($user);
            $client->connect();
            $inbox = $client->getFolder('INBOX');
            $messages = $inbox->messages()->all()->limit(20)->get();

            $this->messages = $messages->map(function ($message) {
                $fromText = 'Desconocido';
                $fromEmail = null;

                try {
                    $fromArray = (array) $message->getFrom();
                    if (! empty($fromArray)) {
                        $first = reset($fromArray);
                        if (is_object($first)) {
                            $fromEmail = $first->mail ?? null;
                            $fromText = $fromEmail ?? (string) $first;
                        } else {
                            $fromText = (string) $first;
                            $fromEmail = $fromText;
                        }
                    }
                } catch (\Throwable $e) {
                    // se queda "Desconocido"
                }

                return [
                    'id' => (string) $message->getUid(),
                    'from' => $fromText,
                    'from_email' => $fromEmail,
                    'subject' => (string) $message->getSubject(),
                    'date' => (string) $message->getDate(),
                    'body' => (string) ($message->getHTMLBody() ?: $message->getTextBody()),
                ];
            })->toArray();

            $this->connectionError = null;
        } catch (\Throwable $e) {
            $this->connectionError = $e->getMessage();
        }
    }

    protected function makeImapClient(User $user): \Webklex\PHPIMAP\Client
    {
        $cm = new ClientManager();

        return $cm->make([
            'host' => $user->imap_host,
            'port' => (int) $user->imap_port,
            'encryption' => $user->imap_encryption ?: false,
            'validate_cert' => true,
            'username' => $user->mail_address,
            'password' => $user->mail_password,
            'protocol' => 'imap',
        ]);
    }

    public function openCompose(): void
    {
        $this->composeForm->fill();
        $this->showCompose = true;
    }

    public function replyTo(string $uid): void
    {
        $message = collect($this->messages)->firstWhere('id', $uid);

        if (! $message) {
            return;
        }

        $this->composeForm->fill([
            'to' => $message['from_email'] ?? '',
            'subject' => str_starts_with($message['subject'], 'Re:') ? $message['subject'] : 'Re: '.$message['subject'],
            'body' => '<p></p><blockquote>'.$message['body'].'</blockquote>',
        ]);

        $this->showCompose = true;
    }

    public function deleteMessage(string $uid): void
    {
        $user = auth()->user();

        try {
            $client = $this->makeImapClient($user);
            $client->connect();
            $folder = $client->getFolder('INBOX');
            $imapMessage = $folder->query()->getMessageByUid($uid);

            if ($imapMessage) {
                $imapMessage->delete();
                Notification::make()->title('Correo eliminado')->success()->send();
            }

            $this->loadInbox();
        } catch (\Throwable $e) {
            Notification::make()->title('No se pudo eliminar')->body($e->getMessage())->danger()->send();
        }
    }

    public function sendMail(): void
    {
        $data = $this->composeForm->getState();
        $user = auth()->user();

        config([
            'mail.mailers.dynamic' => [
                'transport' => 'smtp',
                'host' => $user->smtp_host,
                'port' => $user->smtp_port,
                'encryption' => $user->smtp_encryption ?: null,
                'username' => $user->mail_address,
                'password' => $user->mail_password,
            ],
        ]);

        try {
            Mail::mailer('dynamic')->html($data['body'], function ($message) use ($data, $user) {
                $message->to($data['to'])
                    ->subject($data['subject'])
                    ->from($user->mail_address, $user->name);
            });

            Notification::make()->title('Correo enviado')->success()->send();
            $this->composeForm->fill();
            $this->showCompose = false;
        } catch (\Throwable $e) {
            Notification::make()->title('Error al enviar')->body($e->getMessage())->danger()->send();
        }
    }
}