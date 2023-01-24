$(".time-picker")
	.clockpicker({
		autoclose: true,
		placement: "bottom",
	})
	.attr("readonly", "readonly")
	.css("cursor", "pointer");
//Select all
$("#checkAll").click(function () {
	$(".check").prop("checked", $(this).prop("checked"));
});

$(".date-range").daterangepicker({
	ranges: {
		Today: [moment(), moment()],
		Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
		"Last 7 Days": [moment().subtract(6, "days"), moment()],
		"Last 30 Days": [moment().subtract(29, "days"), moment()],
		"This Month": [moment().startOf("month"), moment().endOf("month")],
		"Last Month": [
			moment().subtract(1, "month").startOf("month"),
			moment().subtract(1, "month").endOf("month"),
		],
	},
	alwaysShowCalendars: true,
	opens: "left",
	locale: {
		format: "DD/MM/YYYY",
	},
});
