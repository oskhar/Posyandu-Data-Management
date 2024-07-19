export const rupiahFormatter = value => new Intl.NumberFormat('id-ID', {
	currency: 'IDR',
	style: 'currency',
}).format(value)