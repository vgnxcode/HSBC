 var openpgp = window.openpgp;
 openpgp.initWorker({ path:'/assets/libs/openpgp/dist/openpgp.worker.js' });


// put keys in backtick (``) to avoid errors caused by spaces or tabs
const pubkey = `-----BEGIN PGP PUBLIC KEY BLOCK-----
Version: BCPG v1.60

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
=0bpV
-----END PGP PUBLIC KEY BLOCK-----`;

const privkey = `-----BEGIN PGP PRIVATE KEY BLOCK-----

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
=0jvz
-----END PGP PRIVATE KEY BLOCK-----`; //encrypted private key
const passphrase = `Vgn@4321`; //what the privKey is encrypted with





// A $( document ).ready() block.
$( document ).ready(function() {
    console.log( "ready!" );

    $("#button").on('click', function () {
        var str_toencrypt = $("#input").val();
        console.log(str_toencrypt);




        const encryptDecryptFunction = async() => {
    const privKeyObj = (await openpgp.key.readArmored(privkey)).keys[0]
    await privKeyObj.decrypt(passphrase)

    const options = {
        message: openpgp.message.fromText(str_toencrypt),       // input as Message object
        publicKeys: (await openpgp.key.readArmored(pubkey)).keys, // for encryption
        privateKeys: [privKeyObj]                                 // for signing (optional)
    }

    openpgp.encrypt(options).then(ciphertext => {
        encrypted = ciphertext.data // '-----BEGIN PGP MESSAGE ... END PGP MESSAGE-----'
        
        return encrypted
    })
    .then(async encrypted => {
        console.log(1);
        console.log(encrypted);
        console.log(2);
        // Create Base64 Object
//var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/++[++^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}


var encodedString = btoa(encrypted);
console.log(encodedString);
       return encrypted;   

    })
}

encryptDecryptFunction();
//console.log(encrypteddata);



    });

});







//console.log(openpgp);