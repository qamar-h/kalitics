
const checkInForm = document.getElementById('check-in-form'),
      liveErrorContainer =  document.getElementById('live-errors'),
       inputs = checkInForm.getElementsByClassName('form-control');


let timer;
inputs.forEach(function(e) {
    e.addEventListener('input', function() {
        clearTimeout(timer);
        timer = setTimeout(() => {
            checkErrors(checkInForm);
        }, 500);
    });
})

function checkErrors(target)
{
    liveErrorContainer.innerText = "";
    liveErrorContainer.style.display = "none";

    return fetch('/validator/check-in/form',{
        method: "POST",
        body: JSON.stringify(getDataForRequest(new FormData(target))),
    })
        .then(response => response.json())
        .then(response => {

            if(typeof response.message != 'undefined') {
                liveErrorContainer.innerText = response.message;
                liveErrorContainer.style.display = "block";
                return true;
            }

            if(typeof response == 'object' && response.length > 0) {
                let error = "<ul>";
                Object.keys(response).map((e) => error += "<li>" + response[e] + "</li>");
                error += "</ul>";
                liveErrorContainer.innerHTML = error;
                liveErrorContainer.style.display = "block";
                return true;
            }

            return false;
        })
        .catch(error => console.log(error));
}

function getDataForRequest(formData)
{
    let data = {};
    for (let key of formData.keys()) {
        data[formatKeyForRequest(key)] = formData.get(key);
    }
    return data;
}

function formatKeyForRequest(key)
{
    let newKey = key.split('check_in[')[1];
    newKey = newKey.split(']')[0];
    return newKey;
}

