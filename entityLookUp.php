<script src="./jquery-3.7.1.min.js"></script>
<script>
$(document).ready(() => {
	loadEntities();
	$("button#addEntityBTN").click(()=>{loadEntities();});
	$("a#addLink").click(()=>{loadEntities();});
});
function loadEntities() {
	$("datalist#entities").load("getEntities.php", (response, status) => {
		if(status === "success") {
			let s = "";
			const entities = response.split("+");
			for(let i = 0; i < entities.length; i++) {
				s += "<option value='"+ entities[i] + "'>";
			}
			document.querySelector('datalist#entities').innerHTML = s;
			console.log(response);
		}
	});
}
</script>