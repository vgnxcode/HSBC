var openpgp = window.openpgp;
openpgp.initWorker({ path:'/assets/libs/openpgp/dist/openpgp.worker.js' });

const pubkeys = `-----BEGIN PGP PUBLIC KEY BLOCK-----
Comment: User-ID:	naveen <naveen@vgn.in>
Comment: Valid from:	4/15/2024 6:34 PM
Comment: Valid until:	4/1/2026 12:00 PM
Comment: Type:	2,048-bit RSA (secret key available)
Comment: Usage:	Signing, Encryption, Certifying User-IDs, SSH Authentication
Comment: Fingerprint:	2B1E0026754BE4213BC74B3CA8D66B0630AC6FA9


mQENBGYdJfoBCADYt9m3ueuxuemrhpv2V9gKdkp1fc2bBcOlWzh3Dc/fsbTWPhYg
FY6NKU7L6tgcnrts6dM2+2Q4yyo2Lfcz1Q69e4XhjeKm7hnwbWQEEFWtj+zNbmeX
lGfmXdWetzUGJIF/rtqjRTVRI61Vx0YOu5oEtVVbkGTztOVA5T2Z5r5SVCroT2DI
G0X0hoYVqF56PbOTbn2JkZ54ZptMwmjFJn3UMGItusA5mdXdal3w0pF+rakS6wFz
vjZg00ePvS3Dt6cxqMGtHtvV/hJmgKdBgk5zz3DHlYR1yfZqclVbbK+5lKk9o6d5
aRTC0ygrerKXCtDB+5P85SDHBn3sPOTZcsFrABEBAAG0Fm5hdmVlbiA8bmF2ZWVu
QHZnbi5pbj6JAVcEEwEIAEEWIQQrHgAmdUvkITvHSzyo1msGMKxvqQUCZh0l+gIb
IwUJA6+VbgULCQgHAgIiAgYVCgkICwIEFgIDAQIeBwIXgAAKCRCo1msGMKxvqWYG
CACPy6c22ZC8yudgL58FmsVjjERqlBkXvwPevS9E1Ur3R7zEzaMt7z+fTNeDPP92
Wz1RjDltcSuICWga/LMvqj875I32uBfBLet+TJXcvmGlmjIPZZTAIjRZ5XVH8n3w
pj1qWG3y1jQQJsMJ82miS9Vn94l605bGf+vb3jZ+tV60ugeXHeaRBuzECcy0qVx2
1MAnryblVumlislVw6OoG30CcnosQ2YV4W5gZKHe/lu340uK9yCRT7Uiu2Srlp2N
XZHRc5wEH+kJ5A9v7gQnhgfzWJK6+a54GQk0iKtS93UIwDM1ATEOrWd7LnOjuxAI
tcmLwrjPiiMPqTwVpciGtGgeuQENBGYdJfoBCACsxYFi6H2I8HP5+iG4AzOrtWgz
9sQnB7TLdM8uGfDLZSQr11c2EpQ93gQf8jD5Rjtg4He75WwyTaEcS2mJvwoJH2iq
6ku0JTyUOhv3FhtelIvldE1HZON2lsvc1FElR94aQE5NYfA3dQggbzmlmZQLezJa
RHhvXpBNymL5ZXMcR7rKzG4IJLpqWYVpnBlKWC7yJ1B/tl53GoBPBB9fLkkLkYlm
qpNqAQ/9RmabyyoDKVxae4arvJA2ceDxe36eZj3pW6QYFRJ4RBZtRFDkgsH4Cwdx
rXATfyU4XDwaCFdF7CDCzotueclZLY/minhJnwf3+5jrWxZwwcW6bWc30Mr1ABEB
AAGJATwEGAEIACYWIQQrHgAmdUvkITvHSzyo1msGMKxvqQUCZh0l+gIbDAUJA6+V
bgAKCRCo1msGMKxvqZnvB/0UdhwqaLogI1yZLRX/nd59jsZouasnE2smhTVtxlw4
4qhCilYBW3FwxFwP3SNTIQaIB/znpViCqHlcg+wxxvhLQmWB4wGoAQ/FLDNpGZi4
nEVJyYbbOY9JLJXN/OejxBP4DJEcheUqrimJJSvQ61wAtIn4MqMW/ipfoLXOENQD
beoNGN0x+AxW+zRESw3N+niSQhy7Yvgvb+JN0zsjcyQwK8ZVOXaaQEcIK3iJ5Gxn
V1V7DY4XebXai9Pf2UoyQRBrDFSYm1SqHdv4TDn1Wl7Lqf9LoR4bEsTzTJvpjcMi
EqkN/eO3LcaT8Mn+Jh8Ybr2orE3TdLVhF/VOOxEuUGCZ
=1J1U
-----END PGP PUBLIC KEY BLOCK-----`;

const privkey = `-----BEGIN PGP PRIVATE KEY BLOCK-----

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
=0jvz
-----END PGP PRIVATE KEY BLOCK-----`; //encrypted private key
const passphrase = `Vgn@4321`; //what the privKey is encrypted with
const message = 'Hello, World!';

async encryptWithMultiplePublicKeys(pubkeys, privkey, passphrase, message) {
    const privKeyObj = (await openpgp.key.readArmored(privkey)).keys[0]
    await privKeyObj.decrypt(passphrase)

    pubkeys = pubkeys.map(async (key) => {
    	return (await openpgp.key.readArmored(key)).keys[0]
    });

    const options = {
        message: openpgp.message.fromText(message),
        publicKeys: pubkeys,           				  // for encryption
        privateKeys: [privKeyObj]                                 // for signing (optional)
    }

    return openpgp.encrypt(options).then(ciphertext => {
        encrypted = ciphertext.data // '-----BEGIN PGP MESSAGE ... END PGP MESSAGE-----'
        console.log(encrypted);
        return encrypted
    })
   };
