$(document).ready(function() {

	// Bar Chart
	
// Dữ liệu ban đầu
var data = [
    { y: 'Phòng IT', a: 6, b: 0 },
    { y: 'Phòng MKT', a: 0,  b: 1 },
    { y: 'Phòng Bán Hàng', a: 0,  b: 2 },
    { y: 'Phòng Kế Toán', a: 0,  b: 1 },
    { y: 'Phòng Nhân Sự', a: 1,  b: 1 },
];

// Sắp xếp dữ liệu theo tên phòng ban
data.sort((a, b) => (a.y > b.y) ? 1 : -1);

// Vẽ biểu đồ với dữ liệu đã được sắp xếp
Morris.Bar({
    element: 'bar-charts',
    data: data,
    xkey: 'y',
    ykeys: ['a', 'b'],
    labels: ['Nam', 'Nữ'],
    lineColors: ['#ff9b44','#fc6075'],
    lineWidth: '3px',
    barColors: ['#ff9b44','#fc6075'],
    resize: true,
    redraw: true
});

	// Line Chart
	
	Morris.Line({
		element: 'line-charts',
		data: [
			{ y: '2020', a: 0, b: 0 },
			{ y: '2021', a: 0,  b: 0 },
			{ y: '2022', a: 0,  b: 0 },
			{ y: '2023', a: 0,  b: 0 },
			{ y: '2024', a: 7,  b: 5 },
		],
		xkey: 'y',
		ykeys: ['a', 'b'],
		labels: ['Nam', 'Nữ'],
		lineColors: ['#ff9b44','#fc6075'],
		lineWidth: '3px',
		resize: true,
		redraw: true
	});
		
});
