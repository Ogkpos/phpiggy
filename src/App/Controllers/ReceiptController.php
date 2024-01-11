<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{TransactionService, ValidatorService, ReceiptService};

class ReceiptController
{
  public function __construct(
    private TemplateEngine $view,
    private TransactionService $transactionService,
    private ReceiptService $receiptService
  ) {
  }

  public function uploadView(array $params)
  {
    $transaction = $this->transactionService->getUserTransaction($params['transaction']);

    if (!$transaction) {
      redirectTo("/");
    }

    echo $this->view->render("receipts/create.php");
  }

  public function upload(array $params)
  {
    $transaction = $this->transactionService->getUserTransaction($params['transaction']);

    if (!$transaction) {
      redirectTo("/");
    }

    $receiptFile = $_FILES['receipt'] ?? null;

    $this->receiptService->validateFile($receiptFile);

    //Generating random filename
    // $this->receiptService->upload($receiptFile);
    $this->receiptService->upload($receiptFile, $transaction['id']);

    redirectTo("/");
  }

  public function download(array $params)
  {
    //verify if transactin exist
    $transaction = $this->transactionService->getUserTransaction($params['transaction']);

    if (empty($transaction)) {
      redirectTo('/');
    }
    $receipt = $this->receiptService->getReceipt($params['receipt']);

    if (empty($receipt)) {
      redirectTo('/');
    }

    //prevent a user from accessing a receipt from a different transaction
    if ($receipt['transaction_id'] !== $transaction['id']) {
      redirectTo('/');
    }

    //Grabing the file
    $this->receiptService->read($receipt);
  }
  public function delete(array $params)
  {
    //verify if transactin exist
    $transaction = $this->transactionService->getUserTransaction($params['transaction']);

    if (empty($transaction)) {
      redirectTo('/');
    }

    $receipt = $this->receiptService->getReceipt($params['receipt']);

    if (empty($receipt)) {
      redirectTo('/');
    }
    //prevent a user from accessing a receipt from a different  transaction
    if ($receipt['transaction_id'] !== $transaction['id']) {
      redirectTo('/');
    }
    $this->receiptService->delete($receipt);

    redirectTo('/');
  }
}
