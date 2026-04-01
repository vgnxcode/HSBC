var openpgp = window.openpgp;
openpgp.initWorker({ path: "/assets/libs/openpgp/dist/openpgp.worker.js" });

// put keys in backtick (``) to avoid errors caused by spaces or tabs
const pubkey = `-----BEGIN PGP PUBLIC KEY BLOCK-----
Version: BCPG v1.60

mQINBFrfEnwBEADDYQ/jwxtvdSOR+1AQAM+R4Ce1TDCzD5qGF18cs0C1CtAwnY8o
3ZVjs89GluqCUpXNM9Wtzz3V5NjxgbmT5f2KYZMVQS1aF1RaA77RZ1LrHpX0qIsf
s4rS8T5EljGQ6f/N1LOmdYzbv6SZHWG87sCDj7UZ0uTCaqvoFNQlWeMGACIaYCiW
hdAksUeloXkqMjO9FkaWnaO22Hk/N7IQX8DYFTDhQ7mTVLjItS/yvFeouH7bbIoL
aulhD/6/V721oRgcnJ5oDpPZJPXsb7znF6rloCh/yk5VYX5khFrFe344rYQ/Q6AJ
GR60aXEo4XyUzpe2qgvdJ2fTXiwqHN021OqG1GtBVzrCrBkx15Uk+fm+YvSo5qy7
/yt7F63SfqzhIPlntOA9xTZbeCbDff7oRb/o1iKWsLVia2u+Uy/WmbRR5XPTcnnO
Ein1tqgy4vcnU42+aCSEbZDz+lSISYAYojYJOnOZmrVzyABtTRNqrm4rqIHLH0wS
0jHfCyRM6n0wXCNLnim8hcBO+JoD5hMpPje1anHnOkIkmIU/zM8O7CF7aiKf7s6x
ng+FOZ70nDIbZ54mjwnQf2F0iLOxyUmVgkzJ7edDiBHGOqabyX3tI7bi10Z52q+Y
Sm2UupmQkB8vOn5q91RzhDEHFWCroewXne9J0B7xzPA13go8KWf/GHReAQARAQAB
tGhDb25uZWN0IERpZ2l0YWwgLSBNYXBwaW5nICBWYWxpZGF0aW9uIFBvZCA8Y21i
aXRjb25uZWN0ZGlnaXRhbG1hcHBpbmd2YWxpZGF0aW9uQG5vZXh0ZXJuYWxtYWls
LmhzYmMuY29tPokCQgQTAQgALAUCWt8SfAIZAQcLCQgHAgEEBRUICQoLBRYCAwEA
AhsjAh4BAheABYkDw7iAAAoJEEIjooSA8bmicBMQAITeVqTSVJVPqs94pEozeKbP
J4+IyLZg+3eRPwUdLMtpZHeN12wAIEzW+Y9Uf9Rd2qn3rB4DLZNSiHHkPjoByniC
5x3x9j5E0l9uEC2gb5uI4LB9Gun6TKA94vcokpjNByWSIbZwLzR7XXJm0S+HKF4p
6cjy7oMCt2b2sd6j2w8j71LzmSCsfQCbnjmOBkhw+25f6dQl92ta5VkDMc7YiPoW
pWxAzwSGDOGuntn1vFB64nBLkdk7LjzJERShos1jZDWP7GUrv7a1NzXh8WmlWyAp
Q0P6bjxGTJqkgr0HxYKUK3fehM3A7hLycWZzqOAm/scCkiTEJ5MvK3Qw5T5olO/N
YMsTslPl3dEynGyNas1gKxRlaJxHsvRNr07yUell06K4+6liahrhwaw2f+SnA94l
nXOV0rN7xKS7MywMSxt8j10CYTzQBd1WrtHKgBp6LfEE9v96j+4IJyVPXBWXenJD
7G0PvStEF9p6QHxKR4yYFD+i1muRoUrZXuHWAYk//ScTvTmE7xkrBJjNmD5hJz1U
BUYKSO3fjtdevKVAhMFC41CODVFosBvKzKjL8D1kKca3dUFz/NaSWMYZpyjPqN9H
769dzT1eYBWG30g7w27ODw4KxqozeC27vB/kgrRUDeySpqAX895qLZZdtsS48YX3
2D82dsditmuqpSz2udbZuQINBFrfEnwBEACcwoz0J9ha721/WrLxlNYU3Id9GvHP
+79oNgyrH4i2jEyPr90c48PfsGwS5kqGLEAfjKl1AsA9KqTu57cW+koQw/GywO6P
Jxb9usi1dmnnEXcEZc0XmMqOYhr/9bncMATxGZ664hRXU2ToaLU3RvrsR4aLFxCp
pJClJGzRfCXs80ZrvE9qWSh2QlJfqh6hFAqc7UMTniawcikS/oJwC6ruvYSKv2ub
1Tgn0NcS0aLau8jWt2b5ESqFnXN01VWrrfr0S3tOdbfDxXMtTCt+LXqQsYXLhtq3
fzaSUlA0L63kVCRTD9zy9UcxOucbSeZLrVCHHl78paqYEwciQqr25g8wXAXXdBcX
EHvqF+bs1Qgm0d/mWp6Bs6Fkhi8oB8quByMjT8J6SC3goup2t6n7Bw0Q5vxPow2L
Zsiuur+iPYsW51W9qiqwQkKcApx7dnpaqqOYZZodNRKzvPy5sBjaFaKCX5aDQ85/
mJ1Q5jqQBR0u+OmDOx+FlRmrVc0Hj/BCmH59gCfeMXYEDHY38HNEqXvbpWVrxe6t
OAwdIfpHOFDRMz5dgRh/ScED25fRbAUx59bZlCQvD1IfFea0qXYvdnCFoRBmLIAj
qAU4RIFkYN21Yk4amxenJpPeVvlUG57u9derT83G3a4vxGz4ya0LDVL36DeOukc9
VWBHYCFqlfmHpQARAQABiQIfBBgBCAAJBQJa3xJ9AhsMAAoJEEIjooSA8bmiIcUQ
AJP4Az9zCovzV9W3tvNKdx/YBLwxubc0Es5KqgUyvDM3q30pmJNhmmX0zcMiBebr
CzlCCKIQXABnqnnoVDgIn5ipFuZJZ2AAC/FqEJkD7XrKyUKYIrtxz9/RwJeREYx3
biSHIm5zMKN4JeRtzJbE++FRSLRnBXJjAWj2pbhrpaPw56Dtj73uunvTZ75rKyM3
mjmNCtZ1T4ko/xhQ0LDggvliIZZORzeRA8CwDsVN7hd/H/vhsF2hBfQjjRXLQzFc
BWUqjyoWLib8MCrMEL3geJsiWj+cd5f8Jht7G36YPV2miYLk6VWesfrUopKR830j
VZGIpJaIbTiQ0Dz9IwU8E7+96q6FE+eEPL3vBYm76loDZLD+xY1Je4nQV1DWEUB9
ckKW/Iix5kdN97BpY9Z5E6dKqTVWByvbpOyeHfefWhbyMiWK9zRt61FMw9EmJpVz
uFD4bXfWemfpV1bd4EIkQZ92DAshptmFpDtsDclZ+FJCi5tpt4ss8fr5GBTbt9sM
F9v9N1CmEebScjIuh9RR4jvOVVdBy6S8hznnjHN4bX94n1h40L/9ihls5EtS/0zy
7G/N5sAcp6zOTX8U/jTy3zNNjCdKF2E+rW3hRWb1txWqQZoNAMTUca4KmKWOOuje
QDNi/qd+kn8IdMLHhcbutz74Sjcs7ihASa5FoS2E+4bu
=0bpV
-----END PGP PUBLIC KEY BLOCK-----`;

const privkey = `-----BEGIN PGP PRIVATE KEY BLOCK-----

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
uyb1NnA8KTtgHvkaJw==
=/DX9
-----END PGP PRIVATE KEY BLOCK-----`; //encrypted private key
const passphrase = `vGn@1942`; //what the privKey is encrypted with

// A $( document ).ready() block.
$(document).ready(function () {
    console.log("ready!");

    $("#button").on("click", function () {
        var str_toencrypt = $("#input").val();
        console.log(str_toencrypt);

        const encryptDecryptFunction = async () => {
            const privKeyObj = (await openpgp.key.readArmored(privkey)).keys[0];
            await privKeyObj.decrypt(passphrase);

            const options = {
                message: openpgp.message.fromText(str_toencrypt), // input as Message object
                publicKeys: (await openpgp.key.readArmored(pubkey)).keys, // for encryption
                privateKeys: [privKeyObj], // for signing (optional)
            };

            openpgp
                .encrypt(options)
                .then((ciphertext) => {
                    encrypted = ciphertext.data; // '-----BEGIN PGP MESSAGE ... END PGP MESSAGE-----'

                    return encrypted;
                })
                .then(async (encrypted) => {
                    console.log(1);
                    console.log(encrypted);
                    console.log(2);
                    // Create Base64 Object
                    //var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/++[++^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

                    var encodedString = btoa(encrypted);
                    console.log(encodedString);
                    return encrypted;
                });
        };

        encryptDecryptFunction();
        //console.log(encrypteddata);
    });
});

//console.log(openpgp);
