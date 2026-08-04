-- CreateTable
CREATE TABLE "User" (
    "id" TEXT NOT NULL,
    "name" TEXT NOT NULL,
    "email" TEXT NOT NULL,
    "role" TEXT NOT NULL,
    "active" BOOLEAN NOT NULL DEFAULT true,
    "createdAt" TIMESTAMP(3) NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT "User_pkey" PRIMARY KEY ("id")
);

-- CreateTable
CREATE TABLE "Lead" (
    "id" TEXT NOT NULL,
    "name" TEXT NOT NULL,
    "company" TEXT,
    "industry" TEXT,
    "position" TEXT,
    "phone" TEXT,
    "whatsapp" TEXT,
    "email" TEXT,
    "city" TEXT,
    "state" TEXT,
    "employees" INTEGER,
    "revenue" DOUBLE PRECISION,
    "source" TEXT,
    "status" TEXT NOT NULL DEFAULT 'nuevo',
    "hunterId" TEXT,
    "createdAt" TIMESTAMP(3) NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT "Lead_pkey" PRIMARY KEY ("id")
);

-- CreateTable
CREATE TABLE "Qualification" (
    "id" TEXT NOT NULL,
    "leadId" TEXT NOT NULL,
    "hasCompany" BOOLEAN,
    "employees" INTEGER,
    "hasInhouseLawyer" BOOLEAN,
    "hasInsurance" BOOLEAN,
    "hasLawsuits" BOOLEAN,
    "hasOverdueDebt" BOOLEAN,
    "hasBranches" BOOLEAN,
    "decisionMaker" TEXT,
    "revenue" DOUBLE PRECISION,
    "level" TEXT,
    "createdAt" TIMESTAMP(3) NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT "Qualification_pkey" PRIMARY KEY ("id")
);

-- CreateIndex
CREATE UNIQUE INDEX "User_email_key" ON "User"("email");

-- CreateIndex
CREATE UNIQUE INDEX "Qualification_leadId_key" ON "Qualification"("leadId");

-- AddForeignKey
ALTER TABLE "Qualification" ADD CONSTRAINT "Qualification_leadId_fkey" FOREIGN KEY ("leadId") REFERENCES "Lead"("id") ON DELETE RESTRICT ON UPDATE CASCADE;
