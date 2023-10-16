<?php
require_once __DIR__ . '/vendor/autoload.php';

use Nathand\Doctrine\kernel\init;
use Nathand\Doctrine\controller\ClientController;

$entityManager = init::getEntityManager();

$clientController = ClientController::getInstance($entityManager);

// Create multiple clients with some common properties
$client1 = $clientController->create('Test Name 1', 'test1@mail.com');
$client2 = $clientController->create('Test Name 1', 'test2@mail.com');
$client3 = $clientController->create('Test Name 2', 'test1@mail.com');
$client4 = $clientController->create('Test Name 2', 'test2@mail.com');
$id = $client1->getId();

echo "\033[1;31m--- Get All Clients ---\033[0m\n";
// Get all clients
$allClients = $clientController->getAll();
foreach ($allClients as $client) {
    echo "ID: " . $client->getId() . "\n";
    echo "Name: " . $client->getName() . "\n";
    echo "Mail: " . $client->getMail() . "\n";
    echo "ComptesCourants: ";
    $comptesCourants = $client->getComptesCourant();
    if ($comptesCourants !== null) {
        foreach ($comptesCourants as $compteCourant) {
            echo $compteCourant->getId() . " ";
        }
    }
    echo "\n";
    echo "\n";
}

// Define a function to check if a client is in a list of clients
function inClients($client, $clients)
{
    foreach ($clients as $otherClient) {
        if (
            $client->getId() == $otherClient->getId()
            && $client->getName() == $otherClient->getName()
            && $client->getMail() == $otherClient->getMail()
        ) {
            return true;
        }
    }
    return false;
}
echo "\033[1;31m--- Get Clients ---\033[0m\n";
// Test get method with different parameters
echo "\033[1;33m--- Get Clients by Name 'Test Name 1' ---\033[0m\n";
$clients = $clientController->get(null, 'Test Name 1');
foreach ($clients as $client) {
    echo "ID: " . $client->getId() . "\n";
    echo "Name: " . $client->getName() . "\n";
    echo "Mail: " . $client->getMail() . "\n";
    echo "ComptesCourants: ";
    $comptesCourants = $client->getComptesCourant();
    if ($comptesCourants !== null) {
        foreach ($comptesCourants as $compteCourant) {
            echo $compteCourant->getId() . " ";
        }
    }
    echo "\n";
    echo "\n";
    var_dump(inClients($client, $allClients));
}

echo "\033[1;33m--- Get Clients by Mail 'test1@mail.com' ---\033[0m\n";
$clients = $clientController->get(null, null, 'test1@mail.com');
foreach ($clients as $client) {
    echo "ID: " . $client->getId() . "\n";
    echo "Name: " . $client->getName() . "\n";
    echo "Mail: " . $client->getMail() . "\n";
    echo "ComptesCourants: ";
    $comptesCourants = $client->getComptesCourant();
    if ($comptesCourants !== null) {
        foreach ($comptesCourants as $compteCourant) {
            echo $compteCourant->getId() . " ";
        }
    }
    echo "\n";
    echo "\n";
    var_dump(inClients($client, $allClients));
}


echo "\033[1;31m--- Update Clients ---\033[0m\n";
echo "\033[1;33m--- Update Client (no optional parameters) ---\033[0m\n";
// Update a client with only id (no optional parameters)
$updatedClient = $clientController->update($id);

echo "ID: " . $updatedClient->getId() . "\n";
echo "Name: " . $updatedClient->getName() . "\n";
echo "Mail: " . $updatedClient->getMail() . "\n";
echo "ComptesCourants: ";
$comptesCourants = $updatedClient->getComptesCourant();
if ($comptesCourants !== null) {
    foreach ($comptesCourants as $compteCourant) {
        echo $compteCourant->getId() . " ";
    }
}
echo "\n";

// Get the updated client and verify it's the same as the updated one
$updatedClientFromGet = $clientController->get($id)[0];
var_dump($updatedClient == $updatedClientFromGet);

echo "\033[1;33m--- Update Client (all parameters) ---\033[0m\n";
// Update a client with all parameters
$updatedClient = $clientController->update($id, 'Updated Name', 'updated@mail.com');
echo "ID: " . $updatedClient->getId() . "\n";
echo "Name: " . $updatedClient->getName() . "\n";
echo "Mail: " . $updatedClient->getMail() . "\n";
echo "ComptesCourants: ";
$comptesCourants = $updatedClient->getComptesCourant();
if ($comptesCourants !== null) {
    foreach ($comptesCourants as $compteCourant) {
        echo $compteCourant->getId() . " ";
    }
}
echo "\n";
echo "\n";

// Get the updated client and verify it's the same as the updated one
$updatedClientFromGet = $clientController->get($id)[0];
var_dump($updatedClient == $updatedClientFromGet);

echo "\033[1;31m--- Delete Client ---\033[0m\n";
// Delete a client
$clientController->delete($id);

// Get all clients again and verify the deleted client is not in the list
$allClientsAfterDelete = $clientController->getAll();
$deletedClientExists = array_reduce($allClientsAfterDelete, function ($carry, $client) use ($id) {
    return $carry || ($client->getId() === $id);
}, false);
var_dump(!$deletedClientExists);

// Delete the rest of the created clients
$clientController->delete($client2->getId());
$clientController->delete($client3->getId());
$clientController->delete($client4->getId());

// Get all clients again and print the result
$allClientsAfterDelete = $clientController->getAll();
foreach ($allClientsAfterDelete as $client) {
    echo "ID: " . $client->getId() . "\n";
    echo "Name: " . $client->getName() . "\n";
    echo "Mail: " . $client->getMail() . "\n";
    echo "ComptesCourants: ";
    $comptesCourants = $client->getComptesCourant();
    if ($comptesCourants !== null) {
        foreach ($comptesCourants as $compteCourant) {
            echo $compteCourant->getId() . " ";
        }
    }
    echo "\n";
    echo "\n";
}

