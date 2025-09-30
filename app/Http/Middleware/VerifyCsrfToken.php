<?php

namespace vgn\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification..
     *
     * @var array
     */
    protected $except = ['/selldo_4thapi','/selldo_5thapi','/newgeneratepaymentlink','/bps_response','/bps','/aadhaarverify/genotp','/aadhaarverify/submitotp','/checkvendorregfile','/manual_leave_quota','/msppercentageupdate','/projectdetails_crud','/projectdetails_crud_update','/projectsqftins_update','/msproject_fetchstetdate','/fairmont/Buy-luxury-flats-Guindy','/coasta/commercial','/fairmont/duplex','/homebuildingleadsform','/interiorsleadsform','/project-lead','/interior-lead','/kensington-towers-lead','/kensington-towers-lead-google','/kensington-towers-lead-google-blackmount'];
}
