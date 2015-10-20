var la_dict = {};

$(window).on('hashchange', function () {
    removeHash();
});
if (typeof (removeParam) !== 'undefined') {
    var new_url = removeParam('rescuewebsessionid', document.URL);
}
if (document.URL !== new_url && typeof (new_url) !== 'undefined') {
    window.location = new_url;
}

function getCookie(name) {
    var cookieValue = null;
    if (document.cookie && document.cookie != '') {
        var cookies = document.cookie.split(';');
        for (var i = 0; i < cookies.length; i++) {
            var cookie = jQuery.trim(cookies[i]);
            // Does this cookie string begin with the name we want?
            if (cookie.substring(0, name.length + 1) == (name + '=')) {
                cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                break;
            }
        }
    }
    return cookieValue;
}

var csrftoken = getCookie('csrftoken');

$.ajaxSetup({
    beforeSend: function (xhr, settings) {
        if (!this.crossDomain) {
            xhr.setRequestHeader('X-CSRFToken', csrftoken);
        }
    }
});

function get_nice_url(url) {
    var newPathname = "/",
        pathArr = url.split('/');
    if (pathArr[0] == "") pathArr.splice(0, 1);
    if (pathArr[pathArr.length - 1] == "") pathArr.pop();
    for (var i = 0; i < pathArr.length - 1; i++) {
        newPathname += pathArr[i];
        newPathname += "/";
    }
    return newPathname;
}

function start_channel(data) {
    if (data === null) return;
    var url = get_nice_url(window.location.pathname);
    loadInstantChat(
        data['full_name'],
        data['case_reference'],
        data['client_name'],
        data['product_name'],
        data['license_public_key'],
        data['language'],
        url,
        data['code']
    );
}


function change_la_image(btn, case_ref) {
    img = btn.buttonDiv.children[0];
    if (img) {
        img.src = btn['url'];
        clearInterval(btn['interval']);
        btn["div"].buttonDiv.hidden = false;
        btn["div"].buttonDiv.onclick = "";
        //delete(la_dict[ref]);
    }
}

function create_la_button(btn, e, img_url, case_ref) {
    if (case_ref) {
        ref = case_ref;
    }
    else {
        ref = btn.toString();
    }
    la_dict[ref] = {};
    la_dict[ref]["div"] = LiveAgentTracker.createButton(btn, e);
    la_dict[ref]["url"] = img_url;
    la_dict[ref]["div"].buttonDiv.hidden = true;
    la_dict[ref]["interval"] = setInterval(function () {
        change_la_image(btn, case_ref);
    }, 500);
    console.log(btn.toString(), ref);
    console.log(la_dict[ref], la_dict[ref]["interval"]);
}

function create_lmi_chat_div() {
    var chat_div = document.createElement("div");
    chat_div.id = 'ICContainer';
    chat_div.style.display = "block";
    chat_div.style.position = "fixed";
    chat_div.style.border = "0";
    chat_div.style.overflow = "hidden";
    chat_div.style.zIndex = "999999";
    chat_div.style.width = "340px";
    chat_div.style.height = "550px";
    chat_div.style.bottom = "0px";
    chat_div.style.right = "3px";
    chat_div.style.marginRight = "2px";
    document.body.appendChild(chat_div);
}

function loadInstantChat(full_name, case_reference, client_name, product_name, license_public_key, language, url, lmi_btn_code) {
    language = typeof language !== 'undefined' ? language : 'es';
    create_lmi_chat_div();
    if (!window.location.origin) {
        window.location.origin = window.location.protocol + "//"
            + window.location.hostname
            + (window.location.port ? ':' + window.location.port : '');
    }
    var ICLoader = new RescueInstantChatLoader();
    ICLoader.ICContainer = "ICContainer";
    ICLoader.HostedCSS = window.location.origin + "/static/css/channels/instance_chat.css"; // Default css styles
    ICLoader.HostedLanguagesForChatOnlyMode = window.location.origin + "/static/js/project/channels/logmein/LanguagesForChatOnlyMode.js"; // Default js
    ICLoader.HostedLanguagesForAppletMode = "https://secure.logmeinrescue.com/InstantChat/LanguagesForAppletMode.js"; // Default js
    ICLoader.PrivateCode = null;
    ICLoader.PageTitle = "VirtualCare Chat";
    ICLoader.EntryID = lmi_btn_code; // Channel id!!!
    ICLoader.Name = full_name;
    ICLoader.Comment1 = case_reference;
    ICLoader.Comment2 = client_name;
    ICLoader.Comment3 = product_name;
    ICLoader.Comment4 = license_public_key;
    ICLoader.Comment5 = url;
    ICLoader.Tracking0 = null;
    ICLoader.Language = language;
    ICLoader.HostedErrorHandler = function (ErrorName) {
    };
    ICLoader.Start();
    document.getElementById(ICLoader.ICContainer).style.display = "block";
}

var receiveMessage = function (event) {
    console.log(event.data);
    if ("close-iframe" == event.data) {
        var iframe = $("#ICContainer");
        iframe.remove();
        enable_buttons();
    } else if ("closeOpenedWidget()" == event.data || "closeForm" == event.data ||
        "closeForm()" == event.data) {
        enable_buttons();
    }
}

//receive message event
window.addEventListener("message", receiveMessage, false);

function get_service_from_url() {
    var arr = window.location.pathname.split('/');
    return arr.slice(1, arr.length - 1)[1];
}

function disable_buttons() {
    $(".botones_ayuda").addClass("disabled");
}

function enable_buttons() {
    $(".botones_ayuda").removeClass("disabled");
}

function create_case(channel_type, channel_slug, code) {
        if ($(".botones_ayuda").hasClass("disabled")) return 0;
        disable_buttons();
        if (typeof(LANGUAGE_CODE) == 'undefined') {LANGUAGE_CODE="es"}
        msg = {};
        msg["es"] = 'Es necesario introducir el asunto del caso para su creación';
        msg["en"] = 'Please enter case subject';

        var subject = $('#case_subject').val(),
            help_inline = $('#case_subject_warning');

        if (!subject) {
            help_inline.text(msg[LANGUAGE_CODE]);
            help_inline.show();
            help_inline.addClass('error');
            enable_buttons();
        } else {
            try {
                help_inline.hide();
                help_inline.removeClass('error');
                $.ajax({
                    url: '/api/v1/create_case/',
                    type: 'post',
                    data: {
                        'subject': subject,
                        'service': get_service_from_url(),
                        'entry_channel': channel_slug
                    },
                    success: function (res) {
                        if (res.status == 'success') {
                            //success
                            $('#case_subject').removeAttr('value');
                            start_interaction(channel_type, code, res.data);
                        }
                    },
                    error: function (xhr) {
                        enable_buttons();
                        var errors = $.parseJSON(xhr.responseText).data;
                        console.log(errors);
                    }
                });
            } catch (err) {
                enable_buttons();
                console.log(err.message);
            }
        }
    }

    function start_interaction(channel_type, code, data) {
        if (channel_type == 7) { //lmi
            data['code'] = code;
            if (typeof loadInstantChat !== 'undefined' && $.isFunction(loadInstantChat)) {
                start_channel(data);
            } else {
                enable_buttons();
            }
        }
        else if (channel_type == 6) { //LA
            if (typeof LiveAgentTracker !== 'undefined' && $.isFunction(LiveAgentTracker.openButtonChat)) {
                LiveAgentTracker.openButtonChat($("div[id*=" + code + "]")[0].id);
            } else {
                enable_buttons();
            }
            console.log(channel_type + " la " + code);

        }
        else if (channel_type == 4) { //phone
            enable_buttons();
            window.location = "tel:" + code;
        }
        else if (channel_type == 3) { //script
            $(code).click();
        }
        else if (channel_type == 2) { //self
            window.location = code;
        }
        else if (channel_type == 1) { //new
            window.open(code, "_target");
        }
    }
