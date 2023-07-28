<!DOCTYPE html>
<html>
<head>
    <title>Munitorum Field Manual</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/wh10/assets/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/wh10/assets/css/styles.css">
    <link rel="shortcut icon" href="/wh10/assets/favicon.png">


    <!-- MS Tile - for Microsoft apps-->
    <meta name="msapplication-TileImage" content="/assets/images/munitorum_field_manual.png">

    <!-- Site Name, Title, and Description to be displayed -->
    <meta property="og:site_name" content="Munitorum Field Manual">
    <meta property="og:title" content="Munitorum Field Manual">
    <meta property="og:description" content="Warhammer 10th Ed. Army List Builder">

    <!-- Image to display -->
    <meta property="og:image" content="https://www.ludumify.com/wh10/assets/images/munitorum_field_manual.png">

    <!-- No need to change anything here -->
    <meta property="og:type" content="website"/>
    <meta property="og:image:type" content="image/jpeg">

    <!-- Size of image. Any size up to 300. Anything above 300px will not work in WhatsApp -->
    <meta property="og:image:width" content="300">
    <meta property="og:image:height" content="300">

    <!-- Website to visit when clicked in fb or WhatsApp-->
    <meta property="og:url" content="https://www.ludumify.com/wh10/">

    <!-- Cache de browser mobile es muy persistente -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
</head>
<body>

<div class="container">
    <div class="card mt-4">
        <h5 class="card-header">Munitorum Field Manual - <a
                    href="https://www.warhammer-community.com/warhammer-40000-downloads/" target="_blank">05/07/2023</a>
        </h5>

        <!--        <img class="mx-auto" src="assets/images/munitorum_field_manual.png"/>-->

        <div class="card-body">

            <div class="form-group">
                <label for="faction">Faction:</label>
                <select class="form-select mb-2" id="faction">
                    <!-- Faction options will be populated dynamically -->
                </select>
            </div>

            <label for="name">Unit:</label>


            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <select class="form-select mb-2" id="unit">
                            <!-- Name options will be populated dynamically -->
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group mb-2">
                            <span id="buscaImagen"></span></label>
                        </div>
                    </div>
                </div>
            </div>

            <label for="name">Unit Size:</label>

            <div class="form-group">
                <div id="unitSizeArea">
                    <!--                    content will be here-->
                </div>
            </div>
            <div class="row">
                <div class="col col-xs-6">
                    <div class="text-center">
                        <a href="#" onclick="addNode()"><i class="bi bi-plus-circle-fill text-success"
                                                           style="font-size: 50px; color: black;" id="addUnit"></i></a>
                        <p>Add Unit.</p>
                    </div>
                </div>
                <div class="col col-xs-6">
                    <div class="text-center">
                        <a href="#" onclick="shareToWhatsApp()" target="_blank" rel=noopener>
                            <i class="bi bi-whatsapp" style="font-size: 40px; color: #25d366;"></i>
                        </a>
                        <p>Share Army.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3" id="print-area">
        <div class="card-body">
            <h3 class="card-title" id="factionTitle"><!-- Faction name will be populated dynamically --></h3>
            <h4 class="card-title" id="totalPoints">Total Points: 0</h4>
            <ul class="list-group" id="nodeList"></ul>
        </div>
    </div>

    <!--    ANUNCIOS-->
    <div class="row my-4 responsive">
        <div class="col-sm-12 col-md-6 my-2">
            <div data-mc-src="9d28d15a-14e8-41b1-ac06-dd279faf91a4#null"></div>
            <script src="https://cdn2.woxo.tech/a.js#64a70c1e09e9b788721b25cb" async data-usrc></script>
        </div>
        <div class="text-center col-sm-12 col-md-6 my-2">
            <!--            <a href="https://wa.me/50686169171" target="_blank" rel=noopener>-->
            <!--                <img class="mb-3" src="assets/images/whatsapp.png" alt="WhatsApp" width="200">-->
            <!--            </a>-->
            <a href="https://wa.me/50686169171" target="_blank" rel=noopener class="text-center">
                <img src="assets/images/tattoo.jpg" class="rounded mx-auto d-block mb-3" alt="Tattoo" width="100%"
                     style="max-width: 500px;">
            </a>
        </div>
    </div>
</div>

<script>
    var factionSelect = document.getElementById("faction");
    var selectedFaction = factionSelect.value;

    var unitSelect = document.getElementById("unit");
    var selectedUnit = unitSelect.value;

    var numModels = 0;
    var numPoints = 0;
    let totalPoints = 0;

    const getData = async () => {
        try {
            const res = await fetch('data/monitorum2.json');
            const data = await res.json();

            return data;
        } catch (e) {
            console.log(e);
        }
    };

    const fetchFactionsData = async () => {
        const factions = await getData();
        factions.forEach((element) => {
            fillFactionSelect(element.name);
        });

        changeFactionTitle();
    };

    fetchFactionsData();

    const fetchUnitsByFactionName = async (factionName) => {
        unitSelect.innerHTML = "";

        const factions = await getData();
        let unitsInFaction = factions.find(item => item.name === factionSelect.value);
        unitsInFaction.units.forEach((element) => {
            fillUnitsSelect(element.name, element.unitSizes[0].points);
        })

        imageSearchLink();
        changeFactionTitle();
        document.getElementById("nodeList").innerHTML = "";
        document.getElementById("unitSizeArea").innerHTML = "";
        fetchUnitSizesByUnitName();
    };

    factionSelect.addEventListener("change", fetchUnitsByFactionName);

    const fetchUnitSizesByUnitName = async (unitName) => {
        unitSizeArea.innerHTML = "";

        const factions = await getData();
        let resultados = factions.find(item => item.name === factionSelect.value);
        let resultados2 = resultados.units.find(item => item.name === unitSelect.value);
        resultados2.unitSizes.forEach((element, index) => {
            fillUnitSizesRadios(element, index);
        });
    }

    unitSelect.addEventListener("change", fetchUnitSizesByUnitName);

    function fillUnitSizesRadios(element, index) {
        const unitSizeArea = document.getElementById("unitSizeArea");

        // Crear el elemento input
        const input = document.createElement("input");
        input.setAttribute("type", "radio");
        input.setAttribute("class", "btn-check");
        input.setAttribute("name", "options");
        input.setAttribute("id", `option${index}`);
        input.setAttribute("autocomplete", "off");
        input.setAttribute("value", `[${element.models}, ${element.points}]`);
        input.setAttribute("onclick", "radioClick(this)");
        if (index == 0) {
            input.setAttribute("checked", true);

            radioClick(input);
        }
        // Crear el elemento label
        const label = document.createElement("label");
        label.setAttribute("class", "btn btn-primary m-2");
        label.setAttribute("for", `option${index}`);
        label.textContent = `x${element.models}, ${element.points} points`;

        unitSizeArea.appendChild(input);
        unitSizeArea.appendChild(label);
    }

    document.addEventListener('DOMContentLoaded', function () {
        fetchUnitsByFactionName(selectedFaction);
    });

    function fillFactionSelect(factionName) {
        var option = document.createElement("option");
        option.text = factionName;
        option.value = factionName;
        factionSelect.appendChild(option);
    }

    function fillUnitsSelect(unitName, puntos) {
        var option = document.createElement("option");
        option.text = `${unitName} ${puntos}`;
        option.value = unitName;
        unitSelect.appendChild(option);
    }
</script>

<script>
    function changeFactionTitle() {
        factionSelect = document.getElementById("faction");
        selectedFaction = factionSelect.value;

        unitSelect = document.getElementById("unit");
        selectedUnit = unitSelect.value;

        document.getElementById("factionTitle").innerHTML = selectedFaction;

        totalPoints = 0;
        document.getElementById("totalPoints").textContent = "Total Points: " + totalPoints;
    }
</script>

<script>
    function imageSearchLink() {
        let selectedNameFormated = `%22${unitSelect.value}%22+%2B%22${factionSelect.value}%22`;
        let image_url = "https://www.google.com/search?tbm=isch&q=" + selectedNameFormated;

        var imagen = document.createElement("a");
        imagen.setAttribute("href", image_url);
        imagen.setAttribute("target", "_blank");
        imagen.style.textDecoration = "none";
        imagen.textContent = unitSelect.value;

        var cameraIcon = document.createElement("i");
        cameraIcon.classList = "bi bi-camera-fill me-1";
        cameraIcon.style.fontSize = "20px";

        imagen.prepend(cameraIcon); // Agrega cameraIcon como hijo de imagen

        document.getElementById("buscaImagen").innerHTML = imagen.outerHTML;
    }

    unitSelect.addEventListener("change", imageSearchLink);
</script>

<script>
    function addNode() {
        var selectedName = unitSelect.value;
        var nodeText = `${selectedName} x${numModels}, ${numPoints} points.`;

        var nodeItem = document.createElement("li");
        nodeItem.textContent = nodeText;
        nodeItem.classList = "list-group-item";
        nodeItem.setAttribute("draggable", "true");

        var deleteButton = document.createElement("button");
        deleteButton.classList = "btn-close float-end";
        deleteButton.value = numPoints;
        deleteButton.addEventListener("click", function () {
            totalPoints -= this.value;
            document.getElementById("totalPoints").textContent = "Total Points: " + totalPoints;

            deleteNode(nodeItem);
        });
        nodeItem.appendChild(deleteButton);

        var enhancementIcon = document.createElement("i");
        enhancementIcon.classList = "bi bi-arrow-return-right ms-4 me-1";
        if (selectedName.includes("Enhancement: ")) {
            nodeItem.prepend(enhancementIcon);
        }

        var arrowIcon = document.createElement("i");
        arrowIcon.classList = "bi bi-arrow-down-up me-1";
        nodeItem.prepend(arrowIcon);

        var nodeList = document.getElementById("nodeList");
        nodeList.appendChild(nodeItem);

        totalPoints += numPoints;
        document.getElementById("totalPoints").textContent = "Total Points: " + totalPoints;
    }
</script>

<script>
    function deleteNode(nodeItem) {
        nodeItem.parentNode.removeChild(nodeItem);
    }
</script>

<script>
    function shareToWhatsApp() {
        const printAreaContent = document.getElementById('print-area').innerText;
        const message = encodeURIComponent(printAreaContent);
        const url = `https://wa.me/?text=${message}`;

        //window.location.href = url;
        window.open(url, '_blank');
    }
</script>

<script>
    function radioClick(radioButton) {
        numModels = 0;
        numPoints = 0;

        //console.log(radioButton.value);
        var unitSizeArray = JSON.parse(radioButton.value);
        numModels = unitSizeArray[0];
        numPoints = unitSizeArray[1];
    }
</script>

<script>
    // Configurar eventos de arrastrar y soltar
    const nodeList = document.getElementById("nodeList");
    let draggingElement;

    nodeList.addEventListener("dragstart", (event) => {
        if (event.target.closest("li")) {
            draggingElement = event.target.closest("li");
            event.dataTransfer.effectAllowed = "move";
            event.dataTransfer.setData("text/html", draggingElement.innerHTML);
            draggingElement.classList.add("dragging");
        }
    });

    nodeList.addEventListener("dragover", (event) => {
        event.preventDefault();
        if (event.target.closest("li") && event.target.closest("li") !== draggingElement) {
            nodeList.insertBefore(draggingElement, event.target.closest("li"));
        }
    });

    nodeList.addEventListener("dragend", (event) => {
        draggingElement.classList.remove("dragging");
        draggingElement = null;
    });

    // Eventos táctiles para dispositivos móviles
    nodeList.addEventListener("touchstart", (event) => {
        if (!event.target.closest("button")) {
            draggingElement = event.target.closest("li");
            event.preventDefault();
            draggingElement.classList.add("dragging");
        }
    });

    nodeList.addEventListener("touchmove", (event) => {
        event.preventDefault();
        const touch = event.touches[0];
        const targetElement = document.elementFromPoint(touch.clientX, touch.clientY);
        if (targetElement && targetElement.closest("li") && targetElement.closest("li") !== draggingElement) {
            nodeList.insertBefore(draggingElement, targetElement.closest("li"));
        }
    });

    nodeList.addEventListener("touchend", (event) => {
        draggingElement.classList.remove("dragging");
        draggingElement = null;
    });
</script>

</body>
</html>