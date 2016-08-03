<div>
    Ref : KCGA {! payment.invoice.student_name !} {! payment.invoice.id !}/{!! date('Y') !!}<br>
    {!! trans('messages.date') !!} : {! payment.subscription_invoice.order_date_string !}<br><br>
    {! futureed.BILL_COMPANY !}.<br>
    {! futureed.BILL_STREET !}<br>
    {! futureed.BILL_ADDRESS !}<br>
    {! futureed.BILL_COUNTRY !}<br><br>
    {!! trans('messages.bill_to') !!} : {! payment.invoice.student_name !}<br>
    {! payment.invoice.student.city !}{! ',' + payment.invoice.student.state !}{! ',' + payment.invoice.student.country.name !}<br>
    Attention : {! payment.invoice.student.school.contact_name !}<br><br>
</div>