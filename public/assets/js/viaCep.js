var stateMapping = {
    'AC': "1",
    'AL': "2",
    'AP': "3",
    'AM': "4",
    'BA': "5",
    'CE': "6",
    'DF': "7",
    'ES': "8",
    'GO': "9",
    'MA': "10",
    'MT': "11",
    'MS': "12",
    'MG': "13",
    'PA': "14",
    'PB': "15",
    'PR': "16",
    'PE': "17",
    'PI': "18",
    'RJ': "19",
    'RS': "20",
    'RO': "21",
    'RR': "22",
    'SC': "23",
    'SP': "24",
    'SE': "25",
    'TO': "26",
    'RN': "27",
    'RN': "27",
};

function cleanZipCodeForm() {
    document.getElementById('street').value = ("");
    document.getElementById('neighborhood').value = ("");
    document.getElementById('city').value = ("");
    document.getElementById('state_id').value = ("");
}

function callback(data) {
    if (!("erro" in data)) {
        document.getElementById('street').value = (data.logradouro);
        document.getElementById('neighborhood').value = (data.bairro);
        document.getElementById('city').value = (data.localidade);
        document.getElementById('state_id').value = stateMapping[data.uf];
    } else {
        cleanZipCodeForm();
        alert("CEP não encontrado.");
    }
}

function searchZipCode(valor) {
    var zipCode = valor.replace(/\D/g, '');

    if (zipCode != "") {
        var regexZipCode = /^[0-9]{8}$/;

        if (regexZipCode.test(zipCode)) {
            document.getElementById('street').value = "...";
            document.getElementById('neighborhood').value = "...";
            document.getElementById('city').value = "...";
            document.getElementById('state_id').value = "...";

            fetch(`https://viacep.com.br/ws/${zipCode}/json/`)
                .then(response => response.json())
                .then(data => callback(data))
                .catch(() => {
                    cleanZipCodeForm();
                    alert("Erro ao buscar CEP.");
                });
        } else {
            cleanZipCodeForm();
            alert("Formato de CEP inválido.");
        }
    } else {
        cleanZipCodeForm();
    }
};

