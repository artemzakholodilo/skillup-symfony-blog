<?php


namespace App\Admin\Command;

use App\Model\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// php /var/www/blog.ll/bin/console payment:check:status */5 * * * *
//
//
class PaymentCheckStatus extends Command
{
    protected static $defaultName = 'payment:check:status';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    protected function configure()
    {
        $this->setDescription('Check payment status by order id');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $orders = $this->em->getRepository(Order::class);
        if (!$orders) {
            return;
        }
        $liqPay = new \LiqPay('123123123', '123123123');
//        $liqPay->api('/payment/check', [
//            ''
//        ]);
        $i = 0;
        return 0;
    }

    protected function checkPayment($orderId = null)
    {

    }
}