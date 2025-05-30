<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Order;

class OrderControllerTest extends WebTestCase
{
    public function testDisplayOrders()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/orders');

        self::assertResponseIsSuccessful();
        self::assertSelectorExists('table'); // Assuming orders are in a table
        // Optionally check for table rows
        self::assertGreaterThan(0, $crawler->filter('table tbody tr')->count(), 'No orders displayed');
    }

    public function testAddNewOrder()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/orders/new');

        self::assertResponseIsSuccessful();
        $form = $crawler->selectButton('Create')->form(); // Assuming button label is 'Save'

        // Fill in the form fields to match OrderType
        $form['order[name]'] = 'Test Order Name';
        // Get a valid author id from the select options
        $authorOptions = $crawler->filter('select[name="order[author]"] option')->extract(['value']);
        $form['order[author]'] = $authorOptions[1] ?? $authorOptions[0]; // skip empty value if present
        // Use a valid status value from the OrderStatus enum
        $statusOptions = $crawler->filter('select[name="order[status]"] option')->extract(['value']);
        $form['order[status]'] = $statusOptions[1] ?? $statusOptions[0];

        $client->submit($form);
        self::assertResponseRedirects();
        $client->followRedirect();
        self::assertSelectorExists('.alert-success'); // Assuming a success alert is shown
    }
}
