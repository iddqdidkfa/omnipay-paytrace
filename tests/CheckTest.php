<?php

namespace Omnipay\Paytrace\Test;

use Omnipay\Paytrace\Check;
use Omnipay\Paytrace\Gateway;
use Omnipay\Tests\TestCase;
use Omnipay\Paytrace\Exception\InvalidCheckException;

class CheckTest extends TestCase
{

    /**
     * @var ACH
     */
    protected $check;

    public function setUp()
    {
        parent::setUp();

        $this->check = new Check();
        $this->check->setBankAccount("1234567890");
        $this->check->setRoutingNumber("123456789");
        $this->check->setFirstName("John");
        $this->check->setLastName("Doe");
        $this->check->setPhone("11234567890");
        $this->check->setAddress1("15505 Pennsylvania Ave.");
        $this->check->setCity("Washington DC");
        $this->check->setPostcode("20003");
        $this->check->setState("DC, NE");
        $this->check->setCompany("DAB2LLC");
        $this->check->validate();
    }

    public function testValidateFixture() {
        $this->assertInstanceOf('Omnipay\Paytrace\Check', $this->check);
        $this->assertSame(null, $this->check->validate());
    }

    /**
     * @expectedException \Omnipay\Paytrace\Exception\InvalidCheckException
     * @expectedExceptionMessage The bankAccount parameter is required
     */
    public function testValidateAccountNumberRequired()
    {
        $this->check->setBankAccount(null);
        $this->check->validate();
    }

    /**
     * @expectedException \Omnipay\Paytrace\Exception\InvalidCheckException
     * @expectedExceptionMessage The routingNumber parameter is required
     */
    public function testValidateRountingNumberRequired()
    {
        $this->check->setRoutingNumber(null);
        $this->check->validate();
    }

    /**
     * @expectedException \Omnipay\Paytrace\Exception\InvalidCheckException
     * @expectedExceptionMessage The billingFirstName parameter is required
     */
    public function testValidateAccountName()
    {
        $this->check->setFirstName(null);
        $this->check->validate();
    }

    /**
     * @expectedException \Omnipay\Paytrace\Exception\InvalidCheckException
     * @expectedExceptionMessage The billingLastName parameter is required
     */
    public function testValidateNumber()
    {
        $this->check->setLastName(null);
        $this->check->validate();
    }

    /**
     * @expectedException \Omnipay\Paytrace\Exception\InvalidCheckException
     * @expectedExceptionMessage Invalid Bank Routing Number
     */
    public function testValidateParamatersFailure()
    {
        $this->check->setRoutingNumber('123');
        $this->check->validate();
    }

    public function testConstructWithParams()
    {
        $ach = new Check(array('name' => 'Test Customer'));
        $this->assertSame('Test Customer', $ach->getName());
    }

    public function testInitializeWithParams()
    {
        $ach = new Check;
        $ach->initialize(array('name' => 'Test Customer'));
        $this->assertSame('Test Customer', $ach->getName());
    }

    public function testGetParamters()
    {
        $ach = new Check(array(
            'name' => 'Example Customer',
            'bankAccount' => '1234',
            'routingnumber' => '5678'
        ));

        $parameters = $ach->getParameters();
        $this->assertSame('Example', $parameters['billingFirstName']);
        $this->assertSame('Customer', $parameters['billingLastName']);
        $this->assertSame('1234', $parameters['bankAccount']);
        $this->assertSame('5678', $parameters['routingNumber']);
    }

    public function testFirstName()
    {
        $this->check->setFirstName('Bob');
        $this->assertEquals('Bob', $this->check->getFirstName());
    }

    public function testLastName()
    {
        $this->check->setLastName('Smith');
        $this->assertEquals('Smith', $this->check->getLastName());
    }

    public function testGetName()
    {
        $this->check->setFirstName('Bob');
        $this->check->setLastName('Smith');
        $this->assertEquals('Bob Smith', $this->check->getName());
    }

    public function testSetName()
    {
        $this->check->setName('Bob Smith');
        $this->assertEquals('Bob', $this->check->getFirstName());
        $this->assertEquals('Smith', $this->check->getLastName());
    }

    public function testSetNameWithOneName()
    {
        $this->check->setName('Bob');
        $this->assertEquals('Bob', $this->check->getFirstName());
        $this->assertEquals('', $this->check->getLastName());
    }

    public function testSetNameWithMultipleNames()
    {
        $this->check->setName('Bob John Smith');
        $this->assertEquals('Bob', $this->check->getFirstName());
        $this->assertEquals('John Smith', $this->check->getLastName());
    }

    /* Account Number */
    public function testGetBankAccountNull()
    {
        $this->check->setBankAccount(null);
        $this->assertNull($this->check->getBankAccount());
    }

    /* Billing Company */
    public function testCompany()
    {
        $this->check->setCompany('FooBar');
        $this->assertEquals('FooBar', $this->check->getCompany());
        $this->assertEquals('FooBar', $this->check->getBillingCompany());
        $this->assertEquals('FooBar', $this->check->getShippingCompany());
    }

    public function testBillingCompany()
    {
        $this->check->setBillingCompany('SuperSoft');
        $this->assertEquals('SuperSoft', $this->check->getBillingCompany());
        $this->assertEquals('SuperSoft', $this->check->getCompany());
    }

    public function testBillingAddress1()
    {
        $this->check->setBillingAddress1('31 Spooner St');
        $this->assertEquals('31 Spooner St', $this->check->getBillingAddress1());
        $this->assertEquals('31 Spooner St', $this->check->getAddress1());
    }

    public function testBillingAddress2()
    {
        $this->check->setBillingAddress2('Suburb');
        $this->assertEquals('Suburb', $this->check->getBillingAddress2());
        $this->assertEquals('Suburb', $this->check->getAddress2());
    }

    public function testBillingCity()
    {
        $this->check->setBillingCity('Quahog');
        $this->assertEquals('Quahog', $this->check->getBillingCity());
        $this->assertEquals('Quahog', $this->check->getCity());
    }

    public function testBillingPostcode()
    {
        $this->check->setBillingPostcode('12345');
        $this->assertEquals('12345', $this->check->getBillingPostcode());
        $this->assertEquals('12345', $this->check->getPostcode());
    }

    public function testBillingState()
    {
        $this->check->setBillingState('RI');
        $this->assertEquals('RI', $this->check->getBillingState());
        $this->assertEquals('RI', $this->check->getState());
    }

    public function testBillingCountry()
    {
        $this->check->setBillingCountry('US');
        $this->assertEquals('US', $this->check->getBillingCountry());
        $this->assertEquals('US', $this->check->getCountry());
    }

    public function testBillingPhone()
    {
        $this->check->setBillingPhone('12345');
        $this->assertSame('12345', $this->check->getBillingPhone());
        $this->assertSame('12345', $this->check->getPhone());
    }

    public function testBillingFax()
    {
        $this->check->setBillingFax('54321');
        $this->assertSame('54321', $this->check->getBillingFax());
        $this->assertSame('54321', $this->check->getFax());
    }

    public function testShippingFirstName()
    {
        $this->check->setShippingFirstName('James');
        $this->assertEquals('James', $this->check->getShippingFirstName());
    }

    public function testShippingLastName()
    {
        $this->check->setShippingLastName('Doctor');
        $this->assertEquals('Doctor', $this->check->getShippingLastName());
    }

    public function testShippingName()
    {
        $this->check->setShippingFirstName('Bob');
        $this->check->setShippingLastName('Smith');
        $this->assertEquals('Bob Smith', $this->check->getShippingName());

        $this->check->setShippingName('John Foo');
        $this->assertEquals('John', $this->check->getShippingFirstName());
        $this->assertEquals('Foo', $this->check->getShippingLastName());
    }

    public function testShippingTitle()
    {
        $this->check->setShippingTitle('SuperSoft');
        $this->assertEquals('SuperSoft', $this->check->getShippingTitle());
    }

    public function testShippingCompany()
    {
        $this->check->setShippingCompany('SuperSoft');
        $this->assertEquals('SuperSoft', $this->check->getShippingCompany());
    }

    public function testShippingAddress1()
    {
        $this->check->setShippingAddress1('31 Spooner St');
        $this->assertEquals('31 Spooner St', $this->check->getShippingAddress1());
    }

    public function testShippingAddress2()
    {
        $this->check->setShippingAddress2('Suburb');
        $this->assertEquals('Suburb', $this->check->getShippingAddress2());
    }

    public function testShippingCity()
    {
        $this->check->setShippingCity('Quahog');
        $this->assertEquals('Quahog', $this->check->getShippingCity());
    }

    public function testShippingPostcode()
    {
        $this->check->setShippingPostcode('12345');
        $this->assertEquals('12345', $this->check->getShippingPostcode());
    }

    public function testShippingState()
    {
        $this->check->setShippingState('RI');
        $this->assertEquals('RI', $this->check->getShippingState());
    }

    public function testShippingCountry()
    {
        $this->check->setShippingCountry('US');
        $this->assertEquals('US', $this->check->getShippingCountry());
    }

    public function testShippingPhone()
    {
        $this->check->setShippingPhone('12345');
        $this->assertEquals('12345', $this->check->getShippingPhone());
    }

    public function testShippingFax()
    {
        $this->check->setShippingFax('54321');
        $this->assertEquals('54321', $this->check->getShippingFax());
    }

    public function testAddress1()
    {
        $this->check->setAddress1('31 Spooner St');
        $this->assertEquals('31 Spooner St', $this->check->getAddress1());
        $this->assertEquals('31 Spooner St', $this->check->getBillingAddress1());
        $this->assertEquals('31 Spooner St', $this->check->getShippingAddress1());
    }

    public function testAddress2()
    {
        $this->check->setAddress2('Suburb');
        $this->assertEquals('Suburb', $this->check->getAddress2());
        $this->assertEquals('Suburb', $this->check->getBillingAddress2());
        $this->assertEquals('Suburb', $this->check->getShippingAddress2());
    }

    public function testCity()
    {
        $this->check->setCity('Quahog');
        $this->assertEquals('Quahog', $this->check->getCity());
        $this->assertEquals('Quahog', $this->check->getBillingCity());
        $this->assertEquals('Quahog', $this->check->getShippingCity());
    }

    public function testPostcode()
    {
        $this->check->setPostcode('12345');
        $this->assertEquals('12345', $this->check->getPostcode());
        $this->assertEquals('12345', $this->check->getBillingPostcode());
        $this->assertEquals('12345', $this->check->getShippingPostcode());
    }

    public function testState()
    {
        $this->check->setState('RI');
        $this->assertEquals('RI', $this->check->getState());
        $this->assertEquals('RI', $this->check->getBillingState());
        $this->assertEquals('RI', $this->check->getShippingState());
    }

    public function testCountry()
    {
        $this->check->setCountry('US');
        $this->assertEquals('US', $this->check->getCountry());
        $this->assertEquals('US', $this->check->getBillingCountry());
        $this->assertEquals('US', $this->check->getShippingCountry());
    }

    public function testPhone()
    {
        $this->check->setPhone('12345');
        $this->assertEquals('12345', $this->check->getPhone());
        $this->assertEquals('12345', $this->check->getBillingPhone());
        $this->assertEquals('12345', $this->check->getShippingPhone());
    }

    public function testFax()
    {
        $this->check->setFax('54321');
        $this->assertEquals('54321', $this->check->getFax());
        $this->assertEquals('54321', $this->check->getBillingFax());
        $this->assertEquals('54321', $this->check->getShippingFax());
    }

    public function testEmail()
    {
        $this->check->setEmail('adrian@example.com');
        $this->assertEquals('adrian@example.com', $this->check->getEmail());
    }
}