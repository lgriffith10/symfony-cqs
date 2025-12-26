<?php

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Process\Process;

require dirname(__DIR__).'/vendor/autoload.php';

// 1. Chargement des variables d'environnement
$dotenv = new Dotenv();
$dotenv->loadEnv(dirname(__DIR__).'/.env');

// On force l'environnement de test
$_ENV['APP_ENV'] = $_SERVER['APP_ENV'] = 'test';

// 2. Fonction helper pour exécuter les commandes Symfony proprement
function runCommand(string $command) {
    echo "Executing: $command...\n";
    $process = Process::fromShellCommandline($command);
    $process->setTty(true); // Permet de voir l'output en temps réel
    $process->run();

    if (!$process->isSuccessful()) {
        throw new \RuntimeException(sprintf('Command failed: %s', $command));
    }
}

// 3. Préparation de la base de données
echo "🔄 Initialisation de la base de données de test...\n";

// Création de la DB (si nécessaire)
runCommand('php bin/console doctrine:database:create --env=test --if-not-exists');

// Reset complet du schéma (plus rapide et fiable que les migrations en test)
runCommand('php bin/console doctrine:schema:drop --env=test --force --full-database');
runCommand('php bin/console doctrine:schema:create --env=test');

// Chargement des fixtures
echo "📥 Chargement des fixtures...\n";
runCommand('php bin/console doctrine:fixtures:load --env=test --no-interaction');

echo "✅ Environnement de test prêt !\n";