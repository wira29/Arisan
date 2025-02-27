function formatCurrency(number, locale = 'id-ID', currency = 'IDR') {
var formatter = new Intl.NumberFormat(locale, {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
});
return formatter.format(number);
}