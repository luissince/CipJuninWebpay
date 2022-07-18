function Tools() {

    this.validateDate = function (date) {
        var regex = new RegExp("([0-9]{4}[-](0[1-9]|1[0-2])[-]([0-2]{1}[0-9]{1}|3[0-1]{1})|([0-2]{1}[0-9]{1}|3[0-1]{1})[-](0[1-9]|1[0-2])[-][0-9]{4})");
        return regex.test(date);
    }

    this.validateEmail = function (value) {
        var validRegex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (value.match(validRegex)) {
            return true;
        } else {
            return false;
        }
    }

    this.getDateYYMMDD = function (value) {
        var parts = value.split("/");
        return parts[0] + parts[1] + parts[2];
    }

    this.getDateForma = function (value, format = "dd/mm/yyyy") {
        var parts = value.split("-");
        let today = new Date(parts[0], parts[1] - 1, parts[2]);
        return (
            format == "dd/mm/yyyy" ? (
                (today.getDate() > 9 ? today.getDate() : "0" + today.getDate()) +
                "/" +
                (today.getMonth() + 1 > 9 ?
                    today.getMonth() + 1 :
                    "0" + (today.getMonth() + 1)) +
                "/" +
                today.getFullYear()) :
                today.getFullYear() + "-" + (today.getMonth() + 1 > 9 ? today.getMonth() + 1 : "0" + (today.getMonth() + 1)) + "-" + (today.getDate() > 9 ? today.getDate() : "0" + today.getDate())
        );
    }


    this.getDateFormaDDMM = function (value) {
        var parts = value.split("-");
        let today = new Date(parts[0], parts[1] - 1, parts[2]);
        return (
            (today.getMonth() + 1 > 9 ?
                today.getMonth() + 1 :
                "0" + (today.getMonth() + 1)) +
            "/" +
            today.getFullYear()
        );
    }

    this.getTimeForma = function (value, option) {
        let ar = value.split(":");
        let hr = parseInt(ar[0]);
        let min = parseInt(ar[1]);
        let arsec = ar[2].split(".");
        let sec = parseInt(arsec[0]);
        if (sec < 10) {
            sec = "0" + sec;
        }
        if (min < 10) {
            min = "0" + min;
        }
        let ampm = "am";
        if (hr > 12) {
            hr -= 12;
            ampm = "pm";
        }
        return option ? (hr > 9 ? hr : "0" + hr) + ":" + min + ":" + sec + " " + ampm : hr + ":" + min + ":" + sec;
    }

    this.getTimeForma24 = function (value) {
        let ar = value.split(":");
        let hr = ar[0];
        let min = parseInt(ar[1]);
        let arsec = ar[2].split(".");
        let sec = parseInt(arsec[0]);
        if (sec < 10) {
            sec = "0" + sec;
        }
        if (min < 10) {
            min = "0" + min;
        }
        if (hr > 0 && hr < 10) {
            hr = "0" + hr;
        }
        return hr + ":" + min + ":" + sec;
    }


    this.formatMoney = function (amount, decimalCount = 2, decimal = ".", thousands = "") {
        try {
            decimalCount = Math.abs(decimalCount);
            decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

            const negativeSign = amount < 0 ? "-" : "";

            let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
            let j = (i.length > 3) ? i.length % 3 : 0;

            return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" +
                thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
        } catch (e) {
            return 0;
        }
    }

    this.getCurrentDate = function () {
        let today = new Date();
        let formatted_date = today.getFullYear() + "-" + ((today.getMonth() + 1) > 9 ? (today.getMonth() + 1) : '0' + (
            today.getMonth() + 1)) + "-" + (today.getDate() > 9 ? today.getDate() : '0' + today.getDate());
        return formatted_date;
    }

    this.getCurrentTime = function () {
        let today = new Date();
        let formatted_time = (today.getHours() > 9 ? today.getHours() : '0' + today.getHours()) + ":" + (today.getMinutes() > 9 ? today.getMinutes() : '0' + today.getMinutes()) + ":" + (today.getSeconds() > 9 ? today.getSeconds() : '0' + today.getSeconds());
        return formatted_time;
    }

    this.getCurrentMonth = function () {
        let today = new Date();
        return (today.getMonth() + 1);
    }

    this.getCurrentYear = function () {
        let today = new Date();
        return today.getFullYear();
    }

    this.diasEnUnMes = function (mes, year) {
        mes = mes.toUpperCase();
        var meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
        return new Date(year, meses.indexOf(mes) + 1, 0).getDate();
    }

    this.nombreMes = function (mes) {
        let array = [
            "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
            "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"
        ];
        return array[mes - 1];
    }

    this.isNumeric = function (value) {
        let number = String(value);
        if (number.trim().length === 0 || number === 'undefined')
            return false;

        if (isNaN(number.trim())) {
            return false;
        } else {
            return true;
        }
    };

    this.tableMessage = function (table, message) {
        table.empty();
        table.append(
            '<div class="text-center" style="background-color: #e3e3e3; height: 400px; display:flex; justify-content: center; align-items: center;"><p>' + message + '</p></div>'
        );
    };

    this.ModalDialog = function (title, mensaje, callback) {
        swal({
            title: title,
            text: mensaje,
            type: 'question',
            showCancelButton: true,
            confirmButtonText: "Si",
            cancelButtonText: "No",
            allowOutsideClick: false
        }).then((isConfirm) => {
            if (isConfirm.value) {
                callback(true)
            } else {
                callback(false)
            }
        });
    }

    this.ModalDialogInputText = function (title, mensaje, callback) {
        swal({
            title: title,
            text: mensaje,
            input: 'text',
            inputPlaceholder: 'Ingrese un el motivo de la anulación',
            type: 'question',
            showCancelButton: true,
            confirmButtonText: "Si",
            cancelButtonText: "No",
            allowOutsideClick: false,
        }).then((isConfirm) => {
            callback(isConfirm)
        });
    }


    this.ModalAlertSuccess = function (title, message, callback = function () { }) {
        swal({
            title: title,
            text: message,
            type: "success",
            showConfirmButton: true,
            allowOutsideClick: false
        }).then(() => {
            callback()
        });
    }
    this.ModalAlertWarning = function (title, message, callback = function () { }) {
        swal({
            title: title,
            text: message,
            type: "warning",
            showConfirmButton: true,
            allowOutsideClick: false
        }).then(() => {
            callback()
        });
    }
    this.ModalAlertError = function (title, message) {
        swal({ title: title, text: message, type: "error", showConfirmButton: true, allowOutsideClick: false });
    }
    this.ModalAlertInfo = function (title, message) {
        swal({ title: title, text: message, type: "info", showConfirmButton: false, allowOutsideClick: false, allowEscapeKey: false, });
    }

    this.AlertSuccess = function (title, message, position = "toast-top-right") {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": position,
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        toastr["success"](message, title);
    }

    this.AlertWarning = function (title, message, position = "toast-top-right") {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": position,
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        toastr["warning"](message, title);
    }

    this.AlertError = function (title, message, position = "toast-top-right") {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": position,
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        toastr["error"](message, title)
    }

    this.AlertInfo = function (title, message, position = "toast-top-right") {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": position,
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        toastr["info"](message, title)
    }

    this.fetch_timeout = async function (url, header = { method: "GET" }, timeout = 50000) {

        let primiseTime = new Promise(function (_, reject) {
            setTimeout(reject, timeout, { "state": 0, "message": "Tiempo de espera agotado, intente nuevamente en un par de minutos." })
        });

        let promiseFetch = new Promise(function (resolve, reject) {
            fetch(url, header).then(response => {

                if (response.ok) {
                    return response.text();
                } else {
                    return new Error('Error de conexión.');
                }
            }).then((json) => {
                try {
                    return JSON.parse(json);
                } catch (e) {
                    return new Error('Formato del json no aceptada.');
                }
            }).then((result) => {
                resolve(result);
            }).catch(() => {
                reject({ "state": 0, "message": "Error de conexión del cliente, intente nuevamente en un par de minutos." });
            })
        })
        return Promise.race([primiseTime, promiseFetch]).then(result => result).catch(error => error);
    }

}