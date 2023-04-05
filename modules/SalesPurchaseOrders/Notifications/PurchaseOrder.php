<?php

namespace Modules\SalesPurchaseOrders\Notifications;

use App\Abstracts\Notification;
use App\Models\Document\Document;
use App\Models\Setting\EmailTemplate;
use App\Traits\Documents;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\SalesPurchaseOrders\Models\PurchaseOrder\Model;

class PurchaseOrder extends Notification
{
    use Documents;

    /**
     * Should attach pdf or not.
     *
     * @var bool
     */
    private $attach_pdf;

    public $purchaseOrder;

    /**
     * The email template.
     *
     * @var string
     */
    public $template;

    public function __construct(Document $purchaseOrder, string $template_alias = null, bool $attach_pdf = false)
    {
        parent::__construct();

        $this->purchaseOrder = Model::find($purchaseOrder->id);
        $this->template      = EmailTemplate::alias($template_alias)->first();
        $this->attach_pdf    = $attach_pdf;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $message = $this->initMailMessage();

        // Attach the PDF file
        if ($this->attach_pdf) {
            $this->purchaseOrder->template_path = 'sales-purchase-orders::purchase_orders.print_'
                                                  . setting('sales-purchase-orders.purchase_order.template');
            $message->attach($this->storeDocumentPdfAndGetPath($this->purchaseOrder), ['mime' => 'application/pdf']);
        }

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        $this->initArrayMessage();

        return [
            'purchase_order_id' => $this->purchaseOrder->id,
            'amount'            => $this->purchaseOrder->amount,
        ];
    }

    public function getTags(): array
    {
        return [
            '{purchase_order_number}',
            '{purchase_order_total}',
            '{purchase_order_issued_at}',
            '{purchase_order_expected_delivery_date}',
            '{vendor_name}',
            '{company_name}',
            '{company_email}',
            '{company_tax_number}',
            '{company_phone}',
            '{company_address}',
            '{purchase_order_admin_link}',
        ];
    }

    public function getTagsReplacement(): array
    {
        return [
            $this->purchaseOrder->document_number,
            money($this->purchaseOrder->amount, $this->purchaseOrder->currency_code, true),
            company_date($this->purchaseOrder->issued_at),
            company_date($this->purchaseOrder->extra_param->expected_delivery_date),
            $this->purchaseOrder->contact_name,
            $this->purchaseOrder->company->name,
            $this->purchaseOrder->company->email,
            $this->purchaseOrder->company->tax_number,
            $this->purchaseOrder->company->phone,
            nl2br(trim($this->purchaseOrder->company->address)),
            route('sales-purchase-orders.purchase-orders.show', $this->purchaseOrder->id),
        ];
    }
}
