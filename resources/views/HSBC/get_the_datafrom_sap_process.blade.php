<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
</head>
<body>


<p>You can use the form below to encrypt your message using my PGP Public Key and then securely email the contents to me if you wish.</p>
<textarea id="input" style='width: 100%; min-height: 300px'></textarea>
<button id="button">Encrypt</button>


    
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="/assets/libs/openpgp/dist/openpgp.min.js" ></script>
<!-- <script src="/assets/libs/openpgp/testing.js"></script> -->
<!-- <script src="/assets/libs/openpgp/encryptwithpublickey.js"></script> -->

<!-- <script src="/assets/libs/openpgp/encryptandsend_content_from_vgn.js"></script> -->

<script>
	 var openpgp = window.openpgp;
 openpgp.initWorker({ path:'/assets/libs/openpgp/dist/openpgp.worker.js' });


// put keys in backtick (``) to avoid errors caused by spaces or tabs
const pubkey = `-----BEGIN PGP PUBLIC KEY BLOCK-----
Version: BCPG v1.68

mQINBGa389EBEACsgfyaFRmCnfVjP3o4x/rac8S/T4rKsDYBRqDnC/lwbimVTSc0
mED4s5HAHoEH7bxRz41OQujL6l5YlsKYNKz8KDk8GCg8RAuAPhZoCK5Q27nQIlGy
nMwPToy2FtMpGwCLP5mi4G1tUSoSwMRhgRNZ9b21MAeoERh3oTrjyJriRne8TVDs
HYedhw5W8UhltxwJJAD2EYJoYw2Z1HA3WA3qmkQuxwHNeJDCx2I4BrBtTNEgGBnr
CljwQDxRfEQFBXNJgmciwJhgmCNl9SPf2quglReEHJttiMBKjEWuJg2ICVtPHf0W
vbRaoIK8tA1o+yHdrWFPdmBW8+j0UqpTC7Q6C1xbtdEKFptDoV3CoFc7fnU26RD/
wOpXB4v4jbU++aQC0ACNHjbp7Jv4/NemwxoleywX9Zp5nrMbESKYdex5f+s1zCXO
ignsl+qAqtzqK1QdKMNeG5/b2NL0ZrxHabbhEguJUe4zI+0pL1YVaF0muMyIz/jE
7I2qT0/A0ce83vAwEiuDBxU03dsOCrCxY30nvq8cUIcqY0BpoZt83z2hwYH04+zQ
LcnLsVHR7ipm3Y82b8is8J+z2yy5RIS87Q5CX4pFqYDzBhSlpQH4sV3FbnH2wE12
lQd0vIftiR/2CXACG3jpSsK692x+QUkX+WKFaxfQvOFWgiIJXhIvScjH2wARAQAB
tG5oc2JjX2Jpc19wcmRfcGdwX3B1Yl9rZXkyMDI0MDggKENIRzM2NDMwOTctQmFu
ayBLZXkgUmVuZXdhbCkgPGNtYml0Y29ubmVjdGRpZ2l0YWxtYXBwaW5ndmFsaWRh
dGlvbkBoc2JjLmNvLmluPokCQgQTAQgALAUCZrfz1QIZAQcLCQgHAgEEBRUICQoL
BRYCAwEAAhsjAh4BAheABYkEO7EAAAoJECQ22iHbpiHrqjgP/2u4ijuarxOjfC9L
g0iATRM2LlinD75Sb2U3mafl3Wr0WwxcmfRwUvL7PSm6rXxKhX2ewjX8Kee3L1nS
ARcpFIubxuYR5a6SjlO9Avf57lHMsbUaPP4+OEv0o1cqfche0f28EPtOp69l/lC4
q/H0NarOJlsUfxORTpQ8Ux/Ve9/b0t9MSWx33p7bfP1hwV8oAESGeG8vBc8AtEZd
kxzN/iAYoEeNgxQSn/mbwLPpRomabKMMnS9j4sek6eeHNOEoC9mOgyr0+5Iw8y/e
eyjwYjx9Pz44JpLSiJt3xi8T8YLpmOw9Ek6nKgOMPqVkNma8F2Vh4Dlb/g2TE/Ib
m0j39qVzS+NV0KbcW1GaURuAvXtwQfLkHIrCvobsetm7xYY24Rw+uMiZhrrbuNGV
1St+R1xJ6bLMIG2d/fydqjhFpVsOeidQtv2tSDR2PFrIdqfh4XyIDdyArVoEwr7R
fJfqG73S9EkM5Guiav+Id80qpPrAWCIs+ruX8rerrw0XaQdBKNo4nZwal+CNynNy
1nRyAQfMQRMvgwLFKjX4/uk66S5kZfNPndGW75PaWMNOTLjMb4NfxvHZX5qbVQsl
eu3klz8DK6Aygit7o4PrsoxaUGJrv/2gv/qa61Qo9FpZV3i1P8ZANIQ8MUlRN+7e
bqCSb4vMVoVIyDjalx4Gu8Hy1SZquQINBGa389EBEADIFaUgX1kX84nSKZP06V9k
LVORPTy+mjR2X6VQK8j5EA+5xYdrLGF61n7XMh/dsbU1ifJO1N2bJAMp4Fp0nJKI
LqrEpwUwtf0Jc597X0IEgFan2TtpFLQiSiKBWJZai3RIFygOlAODi1ySYd5k+S3T
m8UakWcIFKe6wzGYWnErbaCTm0B3oOz1jFOXG/3torPT6ypMtb065RCcOpkffpKB
mXkD8BQu3FvB4aY0+dGE7e4mGj5DDc/R7vh/T/Xl6fq6ER7cCVz8aW0ebl6CyPNs
8TqtTut4+KxTxLtAnZ2tFtCktVidM8shNG4UZPLLIc/gIaYBoCQpoCjO/Zl073So
T55cgVyk6ltn3lanE5n14ZHlXabqZb/eRvHLMdnfm6FVysUX3r5/nSOHWVgHZVg7
ecFpg62UAbOrdmwMwtglTt0Js4yq+FjQGacQBQ6qhOLBMf8qIfUm1ggi6zLCNmPb
gy+gVhLCqJgAB3WljABniSM7hIcEFwhLuHaYiE/lKmtpDTbRgphBnGqMtH+6nqjJ
NMhEX+FRAeV/YEL/eWMVm2Bzxd3BLtEH2kHgVgBtsLyj/1my6lThZc0UX6JOmGei
b5chSqOfQG97X7AD62DuzGnLlRLwoUrE/JwW+Rs7BveE2b1sTtp6Z4pBw24OL3N4
xQ2WXa6VxuuXOWT1eBqrQwARAQABiQIfBBgBCAAJBQJmt/PXAhsMAAoJECQ22iHb
piHrvbgP/iLCmQhPqJjwwrapTXkduits+hk8ixmsPeCjizks4K+mU5e9ZbRpwObg
nKi7hQ0B02NPcEc8fqfj6xrJX/YXbJ8tDmrJzbI/krZ6zjd4iT+7LexRfgpoQFUE
9giDEk6A+PJCCQlwqzLGEsB5tlFz4NkNL+/D9KE+MEIcm0JPJuFuqEELjDqpRDDz
RsPM5b8ISVAyTtA+A/bh8U4fr0ZatVjKE3caczw6W6Ncp5VtL9omPqoDbeRIdlQK
mXtaAnbatLF/JOyqP0sKL8oP0HRAJfNoiGZH+QBVJnCUJt2WLQzF2SxUk8WtG5s1
NxdYkIeygrKKfkHmNfnob5odNTlZjfQolaR0zz/bcYc0Pk4CFpZSQCnnAT9PyXrA
6N7EHBROZsfZ4YjDOzY79TbpCD7tcYqt9HzM/J8VI9uOBfqxwpl/BUbtHCX0C+kD
NvHUYlcU3hHxMgd+Kq+gBhHHO3h21Z9ehZhE7aNJX6hO0AOA7zY2vL7rlmUF5BE7
f4YsBtlxzE8vmBj+Jkre5b53iKQZytaVYlFI98WytfrYaHGxIDTviCKFDHvLaZ1G
J7nPE5b/s5wbsyRPFsugYbKKhPtQZHDu7SLEPVBS4lzJdF91O2mpHljyrIKqe16r
iyonjeD/xDD1jB+/kf1VxZ7QO6eTb5H3llilWoUAUPe1LTt7zgTg
=Jbf6
-----END PGP PUBLIC KEY BLOCK-----`;

const privkey = `-----BEGIN PGP PRIVATE KEY BLOCK-----

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
=0jvz
-----END PGP PRIVATE KEY BLOCK-----`; //encrypted private key
const passphrase = `Vgn@4321`; //what the privKey is encrypted with





// A $( document ).ready() block.
$( document ).ready(function() {
    console.log( "ready!" );
    var sapdata = @json($toprocess, JSON_PRETTY_PRINT);
    console.log(sapdata);
		var xmldata = '';
    if(sapdata.length != 0 ){
    	$.each(sapdata, (k,v) => {
    		//console.log(v);
    		xmldata = `<?xml version="1.0" encoding="UTF-8" ?> 
<Document xmlns="urn:iso:std:iso:20022:tech:xsd:pain.001.001.03">
<CstmrCdtTrfInitn>
<GrpHdr>
<MsgId>`+v.Message_Id+`</MsgId>
<CreDtTm>`+v.current_date+`T`+v.current_time+`</CreDtTm>
<NbOfTxs>1</NbOfTxs>
<CtrlSum>`+v.Amount+`</CtrlSum>
<InitgPty>
<Id>
<OrgId>
<Othr>
<Id>ABC25625001</Id>
</Othr>
</OrgId>
</Id>
</InitgPty>
</GrpHdr>
<PmtInf>
<PmtInfId>`+v.payrefid+`</PmtInfId>
<PmtMtd>TRF</PmtMtd>
<PmtTpInf>
<SvcLvl>
<Cd>`+v.hsbc_trans_type+`</Cd>
</SvcLvl>
</PmtTpInf>
<ReqdExctnDt>`+v.current_date+`</ReqdExctnDt>
<Dbtr>
<Nm>`+v.Company_Name+`</Nm>
<PstlAdr>
<StrtNm>`+v.Street_Name+`</StrtNm>
<BldgNb>`+v.Flat_No+`</BldgNb>
<PstCd>`+v.Pin_code+`</PstCd>
<TwnNm>`+v.City+`</TwnNm>
<CtrySubDvsn>`+v.State+`</CtrySubDvsn>
<Ctry>IN</Ctry>
</PstlAdr>
</Dbtr>
<DbtrAcct>
<Id>
<Othr>
<Id>`+v.Company_Account_No+`</Id> 
</Othr>
</Id>
</DbtrAcct>
<DbtrAgt>
<FinInstnId>
<BIC>HSBCINBB</BIC>
<Nm>HSBC</Nm> 
<PstlAdr>
<Ctry>IN</Ctry> 
</PstlAdr>
</FinInstnId>
</DbtrAgt>
<ChrgBr>DEBT</ChrgBr> 
<CdtTrfTxInf>
<PmtId>
<InstrId>`+v.instrid+`</InstrId> 
<EndToEndId>`+v.instrid+`</EndToEndId> 
</PmtId>
<Amt>
<InstdAmt Ccy="INR">`+v.Amount+`</InstdAmt> 
</Amt>
<CdtrAgt>
<FinInstnId>
<ClrSysMmbId>
<MmbId>`+v.IFSC_Code+`</MmbId> 
</ClrSysMmbId>
<Nm>`+v.Beneficiary_Bank_Name+`</Nm>
<PstlAdr>
<Ctry>IN</Ctry> 
</PstlAdr>
</FinInstnId>
</CdtrAgt>
<Cdtr>
<Nm>`+v.Beneficiary_Name+`</Nm>
</Cdtr>
<CdtrAcct>
<Id>
<Othr>
<Id>`+v.Beneficiary_Account_No+`</Id> 
</Othr>
</Id>
</CdtrAcct>
</CdtTrfTxInf>
</PmtInf>
</CstmrCdtTrfInitn>
</Document>`;

var str_toencrypt = xmldata;

 const encryptDecryptFunction = async(tosend, msgid) => {
 	//console.log(tosend);
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
        //console.log(encrypted);
        console.log('converting to base64');
var encodedString = btoa(encrypted);

$.post('/api/hsbc/posttohsbc_instant_receipt', {_token:"{{csrf_token()}}",datatopass: encodedString,'msgid': msgid }, function(data){
    			console.log(data);
    		});
       return encrypted;   

    });
}

encryptDecryptFunction(str_toencrypt, v.Message_Id);

    	});
    }

});







//console.log(openpgp);
</script>

</body>
</html>

