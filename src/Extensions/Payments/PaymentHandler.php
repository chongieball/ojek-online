<?php 

namespace App\Extension\Payments;

class PaymentHandler
{
	private $log;

	private function setLog()
	{
		global $container;

		$this->log = $container['logger'];
	}

	private function setMessageLog($order_id, $status)
	{
		if ($status == 'settlement') {
			$message = 'success';
		} else {
			$message = $status;
		}

		$this->log->pushHandler(new \App\Extensions\Logs\PaymentLog);

		return $this->log->info("Transaction with $order_id $message", ['transaction_id' => $order_id, 'status_payment' => $status]);
	}

	public function handler()
	{
		$notif = new \Veritrans_Notification();

		$status_code = $notif->status_code;
		$transaction = $notif->transaction_status;
		$type = $notif->payment_type;
		$order_id = $notif->order_id;
		$fraud = $notif->fraud_status;

		if ($transaction == 'capture') {
			//for CC, to handler fraud
			if ($type == 'credit_card'){
				if($fraud == 'accept'){
					$status = 'settlement';
				} else {
					$status = 'denied';
				}
			}
		} else {
			$status = $transaction;
		}

		$this->setMessageLog($order_id, $transaction);

		$data = ['status' => $transaction, 'status_code' => $status_code];

		return $data;
	}
}