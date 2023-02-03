// JavaScript Document

function buttonsaveapplication2(url, productid) {

    var url2 = document.getElementById("image_url_application").value;
    var title = document.getElementById("applicationtitle").value;
    const words = url2.split('uploads/');
    
    if(!url2){
        document.getElementById("applicationerror").innerHTML = "Please choose your PDF File";
        return;
    }
    if(!title){
        document.getElementById("applicationerror").innerHTML = "The tittle is empty!";
        return;
    }

    var urldelete = url.replace("bm-application-add.php", "bm-application-delete.php");

    var newurl = url + "?url=" + words[1] + "&title=" + title + "&id=" + productid;

    var xhttp;
	xhttp=new XMLHttpRequest();
	xhttp.onreadystatechange = function() {

	if (this.readyState == 4 && this.status == 200) {
        var response = this.responseText;
        var element = document.createElement("div");
        element.style.cssText = 'margin-top:20px;width:100%;display:inline-block;min-width: 100% !important;';
        var pproductid = "p" + response;
        element.setAttribute("id", pproductid)
        var p = document.getElementById("productgeral_application");
        p.appendChild(element);
        var element2 = document.createElement("div");
        element2.style.cssText = 'cursor: pointer;float:left;width:80px;height:25px;size:16px;background-color:#aa3210;color:white;text-align:center;padding-top:5px;margin-right:10px';
        element2.appendChild(document.createTextNode('Delete'));
        var texttoadd = "buttondeleteapplication('" + urldelete + "', '" + response + "')";
        element2.setAttribute("onclick",texttoadd);
        var p2 = document.getElementById(pproductid);
        p2.appendChild(element2);

        var element3 = document.createElement("div");
        element3.style.cssText = 'float:left;padding-top:5px;size:45px;font-weight:bold;';
        element3.appendChild(document.createTextNode(title));
        document.getElementById(pproductid).appendChild(element3);
	}
	};
	xhttp.open("GET", newurl, true);
	xhttp.send();
}


function buttondeleteapplication(url, productid) {

    var divremove = "p" + productid;
    var newurl = url + "?id=" + productid;

    var xhttp;

	xhttp=new XMLHttpRequest();

	xhttp.onreadystatechange = function() {

	if (this.readyState == 4 && this.status == 200) {
        document.getElementById(divremove).remove();
	}

	};

	xhttp.open("GET", newurl, true);

	xhttp.send();

}

function cchangeFunction() {
    var inputproduct = document.getElementById("relatedproducttitle");
    //console.log(inputproduct.value);

    if (inputproduct.value.length > 3){
        var els = document.getElementsByClassName("productsearch");
        for(var i = 0; i < els.length; i++)
        {
            if (els[i].innerHTML.toLowerCase().includes(inputproduct.value.toLowerCase())){
                els[i].style.display = "inline-block";
            }else{
                els[i].style.display = "none";
            }
        }
    }else{
        var els = document.getElementsByClassName("productsearch");

        for(var i = 0; i < els.length; i++)
        {
            els[i].style.display = "none";
        }
    }
}
function cchangeFunction2(url, urldelete, postid, ppostid, title) {

    document.getElementsByClassName("productsearch").value == "";
    var els = document.getElementsByClassName("productsearch");
    for(var i = 0; i < els.length; i++)
    {
        els[i].style.display = "none";
    }

    var newurl = url + "?related_product_postid=" + postid + "&related_product_ppostid=" + ppostid + "&related_product_title=" + title;
    console.log(newurl);
    var xhttp;
	xhttp=new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

            var response = this.responseText;
            document.getElementById("titlerelatedtext").style.display = "block";
            document.getElementById("relatedproducttitle").value = "";
            
            
            var element = document.createElement("div");
            element.style.cssText = 'margin-top:20px;width:100%;display:inline-block;min-width: 100% !important;';
            var pproductid = "p" + response;
            element.setAttribute("id", pproductid)
            var p = document.getElementById("productgeral_related_product");
            p.appendChild(element);
            var element2 = document.createElement("div");
            element2.style.cssText = 'cursor: pointer;float:left;width:80px;height:25px;size:16px;background-color:#aa3210;color:white;text-align:center;padding-top:5px;margin-right:10px';
            element2.appendChild(document.createTextNode('Delete'));
            var texttoadd = "buttondeleterelatedproduct('" + urldelete + "', '" + response + "')";
            element2.setAttribute("onclick",texttoadd);
            var p2 = document.getElementById(pproductid);
            p2.appendChild(element2);

            var element3 = document.createElement("div");
            element3.style.cssText = 'float:left;padding-top:5px;size:45px;font-weight:bold;';
            element3.appendChild(document.createTextNode(title));
            document.getElementById(pproductid).appendChild(element3);


        }
	};
	xhttp.open("GET", newurl, true);
	xhttp.send();

}

function buttondeleterelatedproduct(url, productid) {

    var divremove = "p" + productid;
    var newurl = url + "?id=" + productid;

    var xhttp;

	xhttp=new XMLHttpRequest();

	xhttp.onreadystatechange = function() {

	if (this.readyState == 4 && this.status == 200) {
        document.getElementById(divremove).remove();
	}

	};

	xhttp.open("GET", newurl, true);

	xhttp.send();

}