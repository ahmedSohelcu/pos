// src/utils/helpers.js
export function formatCurrency(amount, currency = 'USD') {
  // Example: formatCurrency(1000) => '$1,000.00'
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency,
  }).format(amount);
}

// export function formatDate(date) {
//   if (!date) return '';
//   return new Date(date).toLocaleDateString(); //'1/1/2022'
// }

export function formatDate(date) {
  if (!date) return '';
  return new Date(date).toISOString().split('T')[0] ?? ''; //'2022-01-01'
}

export function formatDateTime(date) {
  if (!date) return '';
  return new Date(date).toLocaleString(); //'1/1/2022, 12:00:00 PM'
}

export function formatTime(date) {
  if (!date) return '';
  return new Date(date).toLocaleTimeString(); //'12:00:00 PM'
}

export function formatNumber(num) {
  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'); // '1,000'
}

export function formatNumberWithComma(num) {
  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'); //'1,000'
}

export function slugify(text) {
  return text.toLowerCase().replace(/ /g, '-'); //'hello-world'
}
