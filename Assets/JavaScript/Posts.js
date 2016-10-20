function validateField(sValue, sFieldName) {

    var sValidationMessage = "";
    if (sValue == null || sValue == "") {
        sValidationMessage += "<div>"+sFieldName+" must be filled out </div>";
    }
    var sRegex = new RegExp("(<?.+?>)");
    if (sRegex.test(sValue)) {
        sValidationMessage += "<div>"+sFieldName+" contains non-allowed characters! </div>";
    }

    return sValidationMessage;
}

function validateForm(oForm) {

    var sErrorMessage = '';

    sErrorMessage += validateField(oForm["author"].value, "Author");
    sErrorMessage += validateField(oForm["title"].value, "Title");
    sErrorMessage += validateField(oForm["content"].value, "Content");

    if (sErrorMessage == null || sErrorMessage == "") {

        return true;

    } else {
        var iPostId = parseInt(oForm["id"].value) > 0 ? oForm["id"].value : '';
        var oResponseBlock = document.getElementById("responseBlock"+iPostId);
        oResponseBlock.innerHTML = sErrorMessage;
        oResponseBlock.setAttribute('style', 'display:block');

        return false;
    }
}

function buildUrlBase() {
    var sLocation = window.location.href;
    var aUrl = sLocation.split('/');
    var sUrl = "";
    aUrl.forEach(function(sValue, iKey){
        if (iKey < aUrl.length - 1 ) {
            sUrl += sValue+'/'
        }
    });

    return sUrl;
}

function buildParametersString(oForm) {
    var oData = new FormData(oForm);
    var sParams = "";
    oData.forEach(function(sValue, sKey){
        if(sValue != "" && sValue != null){
            sParams += sKey+"="+sValue+"&"
        }
    });
    sParams = sParams.substring(0, sParams.length - 1);
    return sParams;
}

function sendRequest(sUrl, sParams, callback) {

    // compatible with IE7+, Firefox, Chrome, Opera, Safari
    var oXmlhttp = new XMLHttpRequest();
    oXmlhttp.onreadystatechange = function(){
        if (oXmlhttp.readyState == 4 && oXmlhttp.status == 200){
            callback(oXmlhttp.responseText);
        }
    }
    oXmlhttp.open("POST", sUrl, true);
    oXmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    oXmlhttp.send(sParams);

}

function stringToEl(sString) {
    var oParser = new DOMParser(),
        sContent = 'text/html',
        oDOM = oParser.parseFromString(sString, sContent);

    if(oDOM.body.childNodes.length > 1){
        return oDOM.body.childNodes;
    }else{
        return oDOM.body.childNodes[0];
    }
}

function isMobile(){
    var sTrigger = document.getElementById("editFormTrigger");
    var sTriggerVisibility = window.getComputedStyle(sTrigger).display;
    return sTriggerVisibility == "block";
}

/****************************************/
/* ============= Actions ============== */
/****************************************/

function savePost(oEvent, iPostId) {

    oEvent.preventDefault();
    if (iPostId > 0) {
        var oForm = document.forms["editForm"+iPostId];
    }else{
        var oForm = document.forms["editForm"];
    }
    var bIsFormValid = validateForm(oForm);
    if (bIsFormValid) {

        var sUrl = buildUrlBase();
        sUrl += oForm.getAttribute('action');

        var sParams = buildParametersString(oForm);

        sendRequest(sUrl, sParams, showPostInList)
    }
}

function openEditForm(oEvent, iPostId){

    oEvent.preventDefault();

    var sUrl = buildUrlBase();
    sUrl += 'editForm';

    var sParams = 'id='+iPostId;
    sendRequest(sUrl, sParams, openEditFormCallback);

}

function openEditFormMobile(form) {
    form.setAttribute('style', 'display:block');
}

function deletePost(oEvent, iPostId) {
    oEvent.preventDefault();

    if (confirm("Are you sure you want to delete this post?")) {
        var sUrl = buildUrlBase();
        sUrl += 'deletePost';

        var sParams = 'id=' + iPostId;
        sendRequest(sUrl, sParams, deletePostCallback);
    }
}

function removeMessage(iPostId) {
    var messageBlock = document.getElementById('message'+iPostId);
    messageBlock.remove();
}

function clearFormFields(oForm) {
    oForm.elements.namedItem('author').value = "";
    oForm.elements.namedItem('title').value = "";
    oForm.elements.namedItem('content').value = "";
}

function closeForm(iId) {
    if(iId > 0) {
        document.getElementById('editForm'+iId).remove();
    }

    if (isMobile()) {
        var editForm = document.getElementById('editForm').nextSibling;
        if(editForm != null && editForm!= undefined) {
            editForm.remove();
        }
        document.getElementById('editFormHolder').setAttribute('style', 'display:none');
        document.getElementById('editForm').setAttribute('style', 'display:block')
    } else {
        var oPost = document.getElementsByClassName('post'+iId).item(0);
        oPost.setAttribute('style', 'display:block');
    }
}

/****************************************/
/* ============ Callbacks ============= */
/****************************************/


function showPostInList(sResponse){

    var contentHolder = document.getElementById("contentHolder");
    var oLongestPost = document.getElementById("longestPost");
    var oNodes = stringToEl(sResponse);
    var oNewLongestPostAuthor = oNodes[0];
    var oNewPost = oNodes[1];

    var iId = oNewPost.getAttribute('data-id');
    var oForm = document.getElementById('editForm'+iId);

    if (oLongestPost) {
        if(oForm != undefined && oForm != null){
            if (isMobile()) {
                var oOldPost = document.getElementById('post'+iId);
                contentHolder.replaceChild(oNewPost, oOldPost);
                oForm.remove();
                document.getElementById('editForm').setAttribute('style', 'display:block');
            } else {
                contentHolder.replaceChild(oNewPost, oForm);
            }
        } else {
            contentHolder.insertBefore(oNewPost, oLongestPost.nextSibling);
            oForm = document.getElementById('editForm');
            clearFormFields(oForm);
        }
        contentHolder.replaceChild(oNewLongestPostAuthor, oLongestPost);
    } else {
        contentHolder.appendChild(oNewLongestPostAuthor);
        contentHolder.appendChild(oNewPost);
    }

    if (isMobile()) {
        document.getElementById('editFormHolder').setAttribute('style', 'display:none');
    }

}

function openEditFormCallback(sResponse){

    var oForm = stringToEl(sResponse);
    var oInput = oForm.getElementsByClassName("postId");
    var iId = oInput.id.value;

    if( isMobile() ){
        document.getElementById("editFormHolder").appendChild(oForm);
        document.getElementById("editForm").setAttribute('style', 'display:none');
        document.getElementById("editForm"+iId).setAttribute('style', 'display:block');
        document.getElementById("editFormHolder").setAttribute('style', 'display:block');
    } else{
        var oPost = document.getElementsByClassName('post'+iId).item(0);
        oPost.setAttribute('style', 'display:none');
        document.getElementById("contentHolder").insertBefore(oForm, oPost);
    }

}

function clearErrorMessages(iPostId){
    var oResponseBlock;
    if (iPostId > 0 ) {
        oResponseBlock = document.getElementById("responseBlock"+iPostId);
    } else {
        oResponseBlock = document.getElementById("responseBlock");
    }
    if (oResponseBlock != null) {
        oResponseBlock.setAttribute('style', 'display:none;');
        oResponseBlock.text = '';
    }
}

function deletePostCallback(sResponse) {


    var oLongestPost = document.getElementById("longestPost");
    console.log(oLongestPost);

    var oNodes = stringToEl(sResponse);
    var oNewLongestPostAuthor = oNodes[0];
    var oDeleteMessage = oNodes[1];

    document.getElementById("contentHolder").replaceChild(oNewLongestPostAuthor, oLongestPost);

    var iId = oDeleteMessage.getAttribute('data-id');
    var oPost = document.getElementsByClassName('post'+iId).item(0);

    document.getElementById("contentHolder").replaceChild(oDeleteMessage, oPost);
}
