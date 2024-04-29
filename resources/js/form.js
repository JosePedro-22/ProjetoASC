const BtnSeending = document.getElementById("BtnSeending");
const fileInput = document.getElementById('imagens_respaldo1');
const ArrayElements = Array(6),
    base64Array = [],
    base64ArrayInput = document.getElementById('img_test');

async function processFile(ArrayElements) {

    async function processor(file) {
         return new Promise(async (resolve, reject) => {
            if (file.type === 'text/csv') {
                const reader = new FileReader();
                reader.onload = async function () {
                    try {
                        const base64Data = reader.result.split(',')[1];
                        const data = "data:" + file.type + ";base64,/" + base64Data;
                        base64Array.push(data);
                        resolve();
                    } catch (error) {
                        reject(error);
                    }
                };
                reader.onerror = function (error) {
                    reject(error);
                };
                reader.readAsDataURL(file);
            } else {
                alert('Por favor, selecione um arquivo CSV.');
                reject(new Error('Por favor, selecione um arquivo CSV.'));
            }
        });
    }

    for (let i = 0; i < ArrayElements.length; i++) {
        if (ArrayElements[i] && ArrayElements[i][0]) {
            await processor(ArrayElements[i][0])
        }
    }
    base64ArrayInput.value = JSON.stringify(base64Array)
}

$(document).ready(function () {

    const removeBtn0 = document.querySelector(".remove_btn_2");

    removeBtn0.addEventListener("click", handleRemoveButtonClick);

    function handleRemoveButtonClick(event) {
        const dataFileNumber = event.target.getAttribute("data-filenumber");
        if (dataFileNumber != null) {
            const fileInput = $(`input[data-filenumber="${dataFileNumber}"]`);
            const inputValue = fileInput.val();

            if (inputValue) {
                fileInput.val("");
                ArrayElements[dataFileNumber] = null;
            }
        }
    }

    $('input[type="file"]').change(async function (file) {
        let fileNumber = file.target.getAttribute("data-filenumber");
        let inputValue = $(`input[data-filenumber="${fileNumber}"]`)[0].files;
        const inputElement = $(`input[data-filenumber="${fileNumber}"]`);

        if (inputElement.hasClass('invalid')) inputElement.removeClass('invalid');
        ArrayElements.splice(fileNumber, 1, inputValue);
    });
});

BtnSeending.addEventListener('click', async () => {
    await processFile(ArrayElements);
    document.querySelector("#imagens_respaldo").disabled = true;
    document.querySelector('.loading').style.display = 'block';
    document.getElementById("uploadForm").submit();
});


