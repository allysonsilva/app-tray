<?php

declare(strict_types=1);

namespace App\Applications\Admin\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Sale\DataObjects\SellerDailySalesSummaryData;

class SellerDailySalesReportNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public readonly SellerDailySalesSummaryData $summaryData,
        public readonly Carbon $date
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(__('Relatório de vendas do dia: ' . $this->date->format('d/m/Y')))
            ->line(__('Quantidade: :total', ['total' => $this->summaryData->totalSales]))
            ->line(__('Valor total: :total', ['total' => to_money($this->summaryData->totalAmount)]))
            ->line(__('Valor comissão: :total', ['total' => to_money($this->summaryData->totalCommission)]));
    }
}
