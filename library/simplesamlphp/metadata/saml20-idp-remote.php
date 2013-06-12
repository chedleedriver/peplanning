<?php
/**
 * SAML 2.0 remote IdP metadata for simpleSAMLphp.
 *
 * Remember to remove the IdPs you don't use from this file.
 *
 * See: https://rnd.feide.no/content/idp-remote-metadata-reference
 */

/*
 * Guest IdP. allows users to sign up and register. Great for testing!
 */
$metadata['http://sts.platform.rmunify.com/sts'] = array(
	'name' 		       => 'RM Unifiy Test Service',
	'description'          => 'Test set up for SSO to RM Unifiy Service',
	'SingleSignOnService'  => 'https://sts.platform.rmunify.com/issue/saml/?binding=redirect',
	'certData'	       => 'MIIDmzCCAoOgAwIBAgIJAIcWT/IpV/35MA0GCSqGSIb3DQEBBQUAMD8xITAfBgNVBAMTGHN0cy5wbGF0Zm9ybS5ybXVuaWZ5LmNvbTEaMBgGA1UEDRMRVW5pZnlUb2tlblNpZ25pbmcwHhcNMTIwODI4MDk1MzM1WhcNMjIwODI2MDk1MzM1WjA/MSEwHwYDVQQDExhzdHMucGxhdGZvcm0ucm11bmlmeS5jb20xGjAYBgNVBA0TEVVuaWZ5VG9rZW5TaWduaW5nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA9cRJ6aN82Co39T1qteQCX94eLtXrxTzP7c5zZgPlcRGnXYUV7B68ohL9JDH2DUVOdt5g1K5AlXknfcH4+szTCc/qX3JNAFlQhEuhK7f2HZGBQqX3PIHp/VxLR1A8gnMEgBlqvTGM3bT3qrunnS+fmR6u9/fwHIEdDaW3VcntvD5bboY+wK5LpjYOaju+snC3CeV6wADXM+MQIZt0On5NUYGa1l2X9XfSxmEZ4ynvEc6zv/1YZhyc4UUVD5XcfrQnhmQCnZEYtUL+Yd4Iy6Ov5nGnal640vVLOnH4bKqzE8ailBmLE84aQUyiX44FVKrqcqtwqxpABEJ1ezumbJULqwIDAQABo4GZMIGWMHUGA1UdEQRuMGyCGHN0cy5wbGF0Zm9ybS5ybXVuaWZ5LmNvbYYjaHR0cDovL3N0cy5wbGF0Zm9ybS5ybXVuaWZ5LmNvbS9zdHOGK2h0dHBzOi8vc3RzLnBsYXRmb3JtLnJtdW5pZnkuY29tL3NoaWJib2xldGgwHQYDVR0OBBYEFByaY4DY6S/OsXwMZEnxwhtEMHMVMA0GCSqGSIb3DQEBBQUAA4IBAQAG3jyWE+vDUSTExdgXeNQmQ2Jti3XVTa3rb9E4xksMBrSe6crLTzp0MXNN6QHipcXxjHUNr12jp/Ro/SQCkJ+3msEHEPLryTEtl4G4nBg+RtvU+L4lp7sMGWjbZmTyIVCgjzgmjm+daUpGxLIKn10eWqmxzw8JFD18zKdaQtafkw0g63pgc+sipn4zN5abAoFLzpDWL5YD5vesrhwL5y5dvXkxZGNL6I7UbZ8d68sxYujxv+i8AF/kT9AjJfhAA7sJ1EDLHX8xGq6ABZGU2KYExPgB2L0az99evP/uSuTZP4a6T7ZOwVFtpVAY6pO/vIXjeWPE7UbCV9g6Y5EQMVDa'
);

