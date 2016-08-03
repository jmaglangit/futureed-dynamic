<div>
    Ref : KCGA {! payment.invoice.client_name !} {! payment.invoice.id !}/{!! date('Y') !!}<br>
    {!! trans('messages.date') !!} : {! payment.subscription_invoice.order_date_string !}<br><br>
    {! futureed.BILL_COMPANY !}.<br>
    {! futureed.BILL_STREET !}<br>
    {! futureed.BILL_ADDRESS !}<br>
    {! futureed.BILL_COUNTRY !}<br><br>
    {!! trans('messages.bill_to') !!} : {! payment.invoice.client_name !}<br>
    {! payment.invoice.client.street_address !},{! payment.invoice.client.city !},{! payment.invoice.client.state !},{! payment.invoice.client.country.name !}<br>
    Attention : {! payment.invoice.client.school.contact_name !}<br>
</div>