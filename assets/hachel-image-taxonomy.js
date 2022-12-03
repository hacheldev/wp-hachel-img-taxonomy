jQuery(function ($) {
	$("#taxonomy_image_button").click(function (e) {
		e.preventDefault();

		var frame = wp.media({
			title: "Sélectionner une image",
			button: {
				text: "Utiliser cette image",
			},
			multiple: false,
		});

		frame.on("select", function () {
			var selection = frame
				.state()
				.get("selection")
				.first()
				.toJSON();

			$("#taxonomy_image").val(selection.url);
			$("#taxonomy_image_preview img").remove();
			$("#taxonomy_image_preview").append(
				'<img src="' +
					selection.url +
					'" alt="" style="max-width: 120px; height: auto;"/>'
			);
		});

		frame.on("close", function () {
			$("#taxonomy_image_preview img").each(function () {
				window.URL.revokeObjectURL(this.src);
			});
		});

		frame.open();
	});

	$("#taxonomy_image_clear").click(function () {
		$("#taxonomy_image").val("");
		$("#taxonomy_image_preview").html("");
	});
});
