<?php

namespace App\Filament\Admin\Pages;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Webklex\PHPIMAP\ClientManager;

class ConfiguracionCorreo extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.admin.pages.configuracion-correo';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Configuracion de correo';
    protected static ?string $title = 'Configuracion de correo';
    protected static ?int $navigationSort = 21;
    protected static string|\UnitEnum|null $navigationGroup = 'Correo';

    public ?array $settingsData = [];
    public ?string $connectionError = null;

    public function mount(): void
    {
        $user = auth()->user();

        $this->settingsForm->fill([
            'mail_address' => $user->mail_address,
            'mail_password' => null,
            'imap_host' => $user->imap_host,
            'imap_port' => $user->imap_port ?? 993,
            'imap_encryption' => $user->imap_encryption ?? 'ssl',
            'smtp_host' => $user->smtp_host,
            'smtp_port' => $user->smtp_port ?? 465,
            'smtp_encryption' => $user->smtp_encryption ?? 'ssl',
        ]);
    }

    public function settingsForm(Schema $schema): Schema
    {
        return $schema
            ->statePath('settingsData')
            ->components([
                TextInput::make('mail_address')->label('Correo')->email()->required(),
                TextInput::make('mail_password')->label('Contrasena')->password()->revealable()
                    ->helperText('Dejalo vacio si no quieres cambiarla.'),
                TextInput::make('imap_host')->label('Servidor IMAP (entrante)')->required(),
                TextInput::make('imap_port')->label('Puerto IMAP')->numeric()->default(993)->required(),
                Select::make('imap_encryption')->label('Encriptacion IMAP')
                    ->options(['ssl' => 'SSL', 'tls' => 'TLS'])->default('ssl'),
                TextInput::make('smtp_host')->label('Servidor SMTP (saliente)')->required(),
                TextInput::make('smtp_port')->label('Puerto SMTP')->numeric()->default(465)->required(),
                Select::make('smtp_encryption')->label('Encriptacion SMTP')
                    ->options(['ssl' => 'SSL', 'tls' => 'TLS'])->default('ssl'),
            ]);
    }

    public function saveSettings(): void
    {
        $data = $this->settingsForm->getState();
        $user = auth()->user();

        $user->mail_address = $data['mail_address'];
        if (! empty($data['mail_password'])) {
            $user->mail_password = $data['mail_password'];
        }
        $user->imap_host = $data['imap_host'];
        $user->imap_port = $data['imap_port'];
        $user->imap_encryption = $data['imap_encryption'];
        $user->smtp_host = $data['smtp_host'];
        $user->smtp_port = $data['smtp_port'];
        $user->smtp_encryption = $data['smtp_encryption'];
        $user->save();

        $this->connectionError = null;

        try {
            $client = (new ClientManager())->make([
                'host' => $user->imap_host,
                'port' => (int) $user->imap_port,
                'encryption' => $user->imap_encryption ?: false,
                'validate_cert' => true,
                'username' => $user->mail_address,
                'password' => $user->mail_password,
                'protocol' => 'imap',
            ]);
            $client->connect();
            Notification::make()->title('Conexion exitosa')->success()->send();
        } catch (\Throwable $e) {
            $this->connectionError = $e->getMessage();
            Notification::make()->title('No se pudo conectar')->body($e->getMessage())->danger()->send();
        }
    }
}