<script src='./jquery-3.7.1.min.js'></script>
<script>
$(document).ready(() => {
    loadEntities();
    $("button#addEntityBTN").click(() => { loadEntities(); });
    $("a#addLink").click(() => { loadEntities(); });
    $("a#editProject").click(() => { loadEntities(); });
});
function loadEntities() {
    console.log("Loading entities...");
    $("datalist#entities").load('getEntities.php', (response, status) => {
        if (status === "success") {
            let s = "";
            const entities = response.split("+");
            for (let i = 0; i < entities.length; i++) {
                s += "<option value='" + entities[i] + "'>";
            }
            document.querySelector("datalist#entities").innerHTML = s;
        }
    });
}
</script>