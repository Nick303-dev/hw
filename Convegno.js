
function addConvegno() {
     const container = document.getElementById("partecipantiContainer");
        container.innerHTML = ""; 
    for(let i=document.getElementById("nPartecipanti").value; i>0; i--){
        let nomePartecipante = document.createElement("input");
        nomePartecipante.type = "text";
        nomePartecipante.name = "nomePartecipante"+i;
        nomePartecipante.id = "nomePartecipante"+i;
        nomePartecipante.placeholder = "nomePartecipante "+i;
        let cognomePartecipante = document.createElement("input");
        cognomePartecipante.type = "text";
        cognomePartecipante.name = "cognomePartecipante"+i;
        cognomePartecipante.id = "cognomePartecipante"+i;
        cognomePartecipante.placeholder = "cognomePartecipante ";
        let data_di_nascita = document.createElement("input");
        data_di_nascita.type = "date";
        data_di_nascita.name = "data_di_nascita"+i;
        data_di_nascita.id = "data_di_nascita"+i;
        data_di_nascita.placeholder = "data_di_nascita ";
        let cfPartecipante = document.createElement("input");
        cfPartecipante.type = "text";
        cfPartecipante.name = "cfPartecipante"+i;
        cfPartecipante.id = "cfPartecipante"+i;
        cfPartecipante.placeholder = "cfPartecipante "+i;
        let label = document.createElement("label");
        label.textContent = "Partecipante " + i + ": ";

        document.getElementById("partecipantiContainer").appendChild(label);
        document.getElementById("partecipantiContainer").appendChild(nomePartecipante);
        document.getElementById("partecipantiContainer").appendChild(cognomePartecipante);
        document.getElementById("partecipantiContainer").appendChild(data_di_nascita);
        document.getElementById("partecipantiContainer").appendChild(cfPartecipante);
        }
    }

