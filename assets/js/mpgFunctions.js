var pages = [];

function createKeywords(event, element) {
    var code = (event.keyCode ? event.keyCode : event.which);
    if (code == 13 && element.value != "") { //Enter keycode
        //getting main element from the DOM
        var pageKeywords = element.parentElement.parentElement.parentElement;

        var keywordDiv = document.createElement("div");
        keywordDiv.setAttribute('class', "keyword");

        // creating key input  for single page
        var inputKey = document.createElement("input");
        inputKey.setAttribute('type', 'text');
        inputKey.setAttribute('placeholder', "Key");
        inputKey.setAttribute('name', 'key');
        keywordDiv.appendChild(inputKey);
        //-----------------------------------------

        //creating value input for single page
        var inputValue = document.createElement("input");
        inputValue.setAttribute('type', 'text');
        inputValue.setAttribute('placeholder', "Value");
        inputValue.setAttribute('class', "keyword-value");
        inputValue.setAttribute('name', "value");
        inputValue.setAttribute('onkeypress', "createKeywords(event,this)");

        //creating label for the value
        var label = document.createElement("label");
        label.innerHTML = '=';
        label.appendChild(inputValue);

        keywordDiv.appendChild(label);

        pageKeywords.appendChild(keywordDiv);

        //remove button for keyword
        var button = document.createElement("button");
        button.setAttribute('onclick', "removeKeyword(this)");
        button.innerHTML = "&#10060;";
        keywordDiv.appendChild(button);
    }

}

function removeKeyword(e) {
    e.parentElement.remove();
}

function createPage() {
    var keysLength = document.getElementsByName("key").length;
    if (document.getElementsByName("key")[0].value != '') {

        var singlePage = {};

        for (var i = 0; i < keysLength; i++) {
            var keyResult = document.getElementsByName("key")[i].value;
            var valueResult = document.getElementsByName("value")[i].value;
            singlePage[`_${keyResult}_`] = valueResult;
            // sitePage.push({[keyResult]: valueResult});
            document.getElementsByName("value")[i].value = '';
        }

        if (document.getElementById('media-value').value != "") {
            var media = document.getElementById('media-value').value;
            singlePage['_media_'] = media;
            document.getElementById('mediaUploadStatus').innerHTML = " No Image";
            document.getElementById('media-value').value = "";
        }

        pages.push(singlePage);
    }

}

function retrieveData() {
    if (pages.length != 0) {
        var pagesList = document.querySelector('#pagesList>div');
        pagesList.innerHTML = `<p>Number Of Created Pages : ${Object.keys(pages).length}  </p>`;
        var parent = document.getElementById('wp-content-editor-container');
        var firstChild = parent.firstChild;
        var pageTitleContainer = document.getElementById('page-title-keywords-container');
        var seoTitleContainer = document.getElementById('seo-title-keywords-container');
        var metaDescContainer = document.getElementById('meta-description-keywords-container');
        var div;

        if (document.getElementById('quicktags-keywords-div-container')) {
            div = document.getElementById('quicktags-keywords-div-container');
        } else {
            div = document.createElement('div');
            div.setAttribute('class', 'quicktags-toolbar');
            div.setAttribute('id', 'quicktags-keywords-div-container');
        }

        for (const page in pages) {
            var keysOfThePage = Object.keys(pages[page]);
            for (const key of keysOfThePage) {
                if (!document.querySelector(`button[value="${key}"]`)) {

                    var ContentKeywordBtn = document.createElement('button');
                    ContentKeywordBtn.innerHTML = 'city';
                    ContentKeywordBtn.setAttribute('class', 'pg-keyword-button');
                    ContentKeywordBtn.setAttribute('type', 'button');
                    ContentKeywordBtn.setAttribute('value', `${key}`);
                    ContentKeywordBtn.setAttribute('onClick', 'addToTheContentTextarea(this)');
                    ContentKeywordBtn.innerHTML = `${key.replace(/_/g, "")}`;
                    div.appendChild(ContentKeywordBtn);

                    if (key != "_media_") {
                        var titleKeywordBtn = document.createElement('button');
                        titleKeywordBtn.innerHTML = 'city';
                        titleKeywordBtn.setAttribute('class', 'pg-keyword-button');
                        titleKeywordBtn.setAttribute('type', 'button');
                        titleKeywordBtn.setAttribute('value', `${key}`);
                        titleKeywordBtn.setAttribute('onClick', 'addToTheTitleTextarea(this)');
                        titleKeywordBtn.innerHTML = `${key.replace(/_/g, "")}`;
                        pageTitleContainer.appendChild(titleKeywordBtn);

                        var seoTitleKeywordBtn = document.createElement('button');
                        seoTitleKeywordBtn.innerHTML = 'city';
                        seoTitleKeywordBtn.setAttribute('class', 'pg-keyword-button');
                        seoTitleKeywordBtn.setAttribute('type', 'button');
                        seoTitleKeywordBtn.setAttribute('value', `${key}`);
                        seoTitleKeywordBtn.setAttribute('onClick', 'addToTheSeoTitleTextarea(this)');
                        seoTitleKeywordBtn.innerHTML = `${key.replace(/_/g, "")}`;
                        seoTitleContainer.appendChild(seoTitleKeywordBtn);

                        var metaDescKeywordBtn = document.createElement('button');
                        metaDescKeywordBtn.innerHTML = 'city';
                        metaDescKeywordBtn.setAttribute('class', 'pg-keyword-button');
                        metaDescKeywordBtn.setAttribute('type', 'button');
                        metaDescKeywordBtn.setAttribute('value', `${key}`);
                        metaDescKeywordBtn.setAttribute('onClick', 'addToTheMetaDescriptionTextarea(this)');
                        metaDescKeywordBtn.innerHTML = `${key.replace(/_/g, "")}`;
                        metaDescContainer.appendChild(metaDescKeywordBtn);
                    }


                }

            }

        }
        parent.insertBefore(div, firstChild);
    }

}


function addToTheContentTextarea(element) {
    var textarea = document.getElementById('content');
    textarea.value += " " + element.value;

}

function addToTheTitleTextarea(element) {
    var textarea = document.getElementById('page-title-textarea');
    textarea.value += " " + element.value;

}

function addToTheSeoTitleTextarea(element) {
    var textarea = document.getElementById('seo-title-textarea');
    textarea.value += " " + element.value;

}

function addToTheMetaDescriptionTextarea(element) {
    var textarea = document.getElementById('meta-description-textarea');
    textarea.value += " " + element.value;

}

function addJson() {
    document.getElementById("json").value = JSON.stringify(pages);
}




function Export() {
    var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xlsx|.xls)$/;
    /*Checks whether the file is a valid excel file*/
    if (regex.test($("#excelfile").val().toLowerCase())) {
        var xlsxflag = false; /*Flag for checking whether excel is .xls format or .xlsx format*/
        if ($("#excelfile").val().toLowerCase().indexOf(".xlsx") > 0) {
            xlsxflag = true;
        }
        /*Checks whether the browser supports HTML5*/
        if (typeof(FileReader) != "undefined") {
            var reader = new FileReader();
            reader.onload = function(e) {
                var data = e.target.result;
                /*Converts the excel data in to object*/
                if (xlsxflag) {
                    var workbook = XLSX.read(data, {
                        type: 'binary'
                    });
                } else {
                    var workbook = XLS.read(data, {
                        type: 'binary'
                    });
                }
                /*Gets all the sheetnames of excel in to a variable*/
                var sheet_name_list = workbook.SheetNames;

                var cnt = 0; /*This is used for restricting the script to consider only first sheet of excel*/
                sheet_name_list.forEach(function(y) { /*Iterate through all sheets*/
                    /*Convert the cell value to Json*/
                    if (xlsxflag) {
                        var exceljson = XLSX.utils.sheet_to_json(workbook.Sheets[y]);
                    } else {
                        var exceljson = XLS.utils.sheet_to_row_object_array(workbook.Sheets[y]);

                    }

                    for (const row in exceljson) {
                        var keysOfThePage = Object.keys(exceljson[row]);
                        var page = {};
                        for (const key of keysOfThePage) {
                            page[`_${key}_`] = exceljson[row][key];
                        }
                        pages.push(page);
                    }

                });
            }
            if (xlsxflag) { /*If excel file is .xlsx extension than creates a Array Buffer from excel*/
                reader.readAsArrayBuffer($("#excelfile")[0].files[0]);
            } else {
                reader.readAsBinaryString($("#excelfile")[0].files[0]);
            }
        } else {
            alert("Sorry! Your browser does not support HTML5!");
        }
    } else {
        alert("Please upload a valid Excel file!");
    }
}