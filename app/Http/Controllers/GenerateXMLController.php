<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GenerateXMLController extends Controller
{
    public function generateXml()
    {
        // Obtén los datos necesarios para construir el XML desde el formulario o la base de datos
        $documentData = [
            'field1' => 'asdasdasd',
            'field2' => 'poqioweukjasd',
            // ... otros campos necesarios
        ];

        // Construye el XML manualmente utilizando las funciones nativas de PHP
        $xml = $this->buildXml($documentData);

        // Guarda el XML en un archivo o en la base de datos según tus necesidades
        // ...

        // Devuelve el XML generado en la respuesta
        return response($xml)->header('Content-Type', 'application/xml');
    }

    private function buildXml($data)
    {
        // Crea un objeto SimpleXMLElement para construir el XML
        $root = new \DOMDocument('1.0', 'ISO-8859-1');
        $xml = $root->createElement('Invoice');
        $xml->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $root->appendChild($xml);
        // $xml->registerXPathNamespace('cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        // agregar atributos al root Invoice
        $xml->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $xml->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $xml->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $xml->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:ccts', 'urn:un:unece:uncefact:documentation:2');
        $xml->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:ds', 'http://www.w3.org/2000/09/xmldsig#');
        $xml->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:ext', 'urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2');
        $xml->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:qdt', 'urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2');
        $xml->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:udt', 'urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2');
        $xml->setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        // fin de atributos de root Invoice

        // inicio de nodo EXT EXTENSIONS
        $extensions = $root->createElement('ext:UBLExtensions');
        $xml->appendChild($extensions);
        // inico de nodo EXT EXTENSION
        $extension = $root->createElement('ext:UBLExtension');
        $extensions->appendChild($extension);
        // inicio de nodo EXT EXTENSIONCONTENT
        $extensionContent = $root->createElement('ext:ExtensionContent');
        $extension->appendChild($extensionContent);
        // FIRMA DIGITAL
        // inicio de nodo DS SIGNATURE
        $signature = $root->createElement('ds:Signature');
        $extensionContent->appendChild($signature);
        $signature->setAttribute('Id', 'SignatureSP');
        
        $signedInfo = $root->createElement('ds:SignedInfo');
        $signature->appendChild($signedInfo);
        // inicio de nodo DS CanonicalizationMethod
        $canonicalizationMethod = $root->createElement('ds:CanonicalizationMethod');$signedInfo->appendChild($canonicalizationMethod);
        $canonicalizationMethod->setAttribute('Algorithm', 'http://www.w3.org/TR/2001/REC-xmlc14n20010315');
        // inicio de nodo ds SignatureMethod
        $signatureMethod = $root->createElement('ds:SignatureMethod');
        $canonicalizationMethod->appendChild($signatureMethod);
        $signatureMethod->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#rsasha1');
        // inicio de nodo DS Reference
        $reference = $root->createElement('ds:Reference');
        $signatureMethod->appendChild($reference);
        $reference->setAttribute('URI', '');
        // inicio de nodo ds Transforms
        $transforms = $root->createElement('ds:Transforms');
        $reference->appendChild($transforms);
        // inicio de nodo ds Transform
        $transform = $root->createElement('Transform');
        $transforms->appendChild($transform);
        $transform->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#envelopedsignature');
        // fin de nodo ds Transform

        // inicio y fin de nodo ds DigestMethod
        $digestMethod = $root->createElement('ds:DigestMethod');
        $reference->appendChild($digestMethod);
        $digestMethod->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#envelopedsignature');

        // inicio y fin de nodo ds DigestValue
        // consultar a documentacion
        $digestValue = $root->createElement('ds:DigestValue', 'ryg5Vl+6zuSrAlgSQUYr WeaSQjk='); 
        $reference->appendChild($digestValue);

        // fin de nodo ds SignedInfo

        // inicio y fin de nodo ds SignatureValue
        // consultar a documentacion
        $signatureValue = $root->createElement('ds:SignatureValue', 'SOiGQpmVz7hBgGjIOQNlcwyHkQLC4S7R2zBuNnOUj4KjZQb3//xNPJMRB67m8x1mpQE6pffiH85vMzYLJ9nt7MLLZXOfP+rPGfkJBmNbYxaGLj9v3qZWyyEzHFGKS+8OfVSgMsHNwZ3IqfuICzc/xo8L7sFj+aT16IHf5TYffb0=');
        $signature->appendChild($signatureValue);

        // inicio de nodo ds KeyInfo
        $keyInfo = $root->createElement('ds:KeyInfo');
        $signature->appendChild($keyInfo);
        // inicio de nodo  ds X509Data
        $x509Data = $root->createElement('ds:X509Data');
        $keyInfo->appendChild($x509Data);
        // inicio y fin de nodo ds X509SubjectName
        // consultar documentacion
        $x509SubjectName = $root->createElement('ds:X590SubjectName',
        '1.2.840.113549.1.9.1=#161a4253554c434140534f55544845524e504552552e434f4d2e5045,CN=Juan Robles,OU=20100454523,O=SOPORTE TECNOLOGICOS EIRL,L=LIMA,ST=LIMA,C=PE');
        $x509Data->appendChild($x509SubjectName);
        // inicio y fin de nodo ds X590Certificate
        $X509Certificate = $root->createElement('ds:X509Certificate',
        'MIIESTCCAzGgAwIBAgIKWOCRzgAAAAAAIjANBgkqhkiG9w0BAQUFADAnMRUwEwYKCZImiZPyLGQBGRYFU1VOQVQxDjAMBgNVBAMTBVNVTkFUMB4XDTEwMTIyODE5NTExMFoXDTExMTIyODIwMDExMFowgZUxCzAJBgNVBAYTAlBFMQ0wCwYDVQQIEwRMSU1BMQ0wCwYDVQQHEwRMSU1BMREwDwYDVQQKEwhTT1VUSEVSTjEUMBIGA1UECxMLMjAxMDAxNDc1MTQxFDASBgNVBAMTC0JvcmlzIFN1bGNhMSkwJwYJQ2VydEVucm9sbC9wY2IyMjZfU1VOQVQuY3J0MDcGCCsGAQUFBzAChitmaWxlOi8vXFxwY2IyMjZcQ2VydEVucm9sbFxwY2IyMjZfU1VOQVQuY3J0MA0GCSqGSIb3DQEBBQUAA4IBAQBI6wJQmRpz3C3rorBflOvA9DOa3GNiiB7rtPIjF4mPmtgfo2pK9gvnxmV2pST3ovfu0nbG2kpjzzaaelRjEodHvkcM3abGsOE53wfxqQF5uf/jkzZA9hbLHtE1aLKBD0Mhzc6cvI072alnE6QU3RZ16ie9CYsHmMr+sPHMy8DJU5YrdnqHdSn2D3nhKBi4QfT/WURPOuo6DF4iWgrCyMf3eJgmGKSUN3At5fK4HSpfyURT0kboaJKNBgQwy0HhGh5BLM7DsTi/KwfdUYkoFgrY71Pm23+ra+xTow1Vk9gj5NqrlpMY5gAVQXEIo1++GxDtaK/5EiVKSqzJ6geIfz');
        $x509Data->appendChild($X509Certificate);
        // fin de nodo X590Data
        // fin de nodo KeyInfo
        // fin de nodo Signature
        // END FIRMA DIGITAL

        // fin de nodo ExtensionContent
        // fin de nodo UBLExtension
        // fin de nodo UBLExtensions

        // INFORMACION DE DOCUMENTO ELECTRONICO
        // inicio y fin de nodo cbc UBLVersionID
        $ublVersionID = $root->createElement('cbc:UBLVersionID', '2.1');
        $xml->appendChild($ublVersionID);
        // inicio y fin de nodo cbc CustomizationID
        $customizationID = $root->createElement('cbc:CustomizationID', '2.0');
        $xml->appendChild($customizationID);
        // inicio y fin de nodo cbc ProfileID con atributos
        // consultar documentacion
        $profileID = $root->createElement('cbc:ProfileID', 'consultar documentacion');
        $xml->appendChild($profileID);
        $profileID->setAttribute('schemeName', 'SUNAT:Identificador de Tipo de Operación');
        $profileID->setAttribute('schemeAgencyName', 'PE:SUNAT');
        $profileID->setAttribute('schemeURI', 'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo17');
        // inicio de nodo cbc ID
        // serie de BOLETA o FACTURA
        $id = $root->createElement('cbc:ID', 'consultar documentacion');
        $xml->appendChild($id);
        // inicio de nodo cbc IssueDate y IssueTime
        // Fechas de factura/boleta
        $issueDate = $root->createElement('cbc:IssueDate', 'poner fecha de factura');
        $xml->appendChild($issueDate);
        $issueTime = $root->createElement('cbc:IssueTime', 'poner hora de factura');
        $xml->appendChild($issueTime);
        // $dueDate = $xml->appendChild('cbc:DueDate','poner fecha de vencimiento')
        // inicio y fin de nodo cbc InvoiceTypeCode y atriutos
        $invoiceTypeCode = $root->createElement('cbc:InvoiceTypeCode', 'consultar documentacion');
        $xml->appendChild($invoiceTypeCode);
        $invoiceTypeCode->setAttribute('listAgencyName', 'PE:SUNAT');
        $invoiceTypeCode->setAttribute('listName', 'SUNAT:Identificador de Tipo de Documento');
        $invoiceTypeCode->setAttribute('listURI', 'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01');

        // inicio de nodo cbc Note
        // Notas del comprobante
        // 1000 significa monto en letras
        $note = $root->createElement('cbc:Note','DIEZ LUQUITAS Y 00/100');
        $xml->appendChild($note);
        $note->setAttribute('languageLocaleID','1000');

        // inicio de nodo cbc DocumentCurrencyCode
        // Codigo de tipo de moneda
        $documentCurrencyCode = $root->createElement('cbc:DocumentCurrencyCode','PEN');
        $xml->appendChild($documentCurrencyCode);
        $documentCurrencyCode->setAttribute('listID','ISO 4217 Alpha');
        $documentCurrencyCode->setAttribute('listName','Currency');
        $documentCurrencyCode->setAttribute('listAgencyName','United Nations Economic Commission for Europe');
        // inicio y fin de nodo cbc LineCountNumeric
        // cantidad de items de la factura
        $lineCountNumeric = $root->createElement('cbc:LineCountNumeric','cantidad de items');
        $xml->appendChild($lineCountNumeric);
        // inicio de nodo cac OrderReference
        $orderReference = $root->createElement('cac:OrderDReference');
        $xml->appendChild($orderReference);
        // inicio y fin de nodo cbc ID
        $id = $root->createElement('cbc:ID','consultar documentacion');
        $orderReference->appendChild($id);
        // fin de nodo cac OrderReference

        // inicio de nodo cac Signature
        $signature = $root->createElement('cac:Signature');
        $xml->appendChild($signature);
        // inicio y fin de nodo cbc ID
        $id = $root->createElement('cbc:id','IDSignSP');
        $signature->appendChild($id);

        // inicio de nodo cac SignatoryParty
        $signatoryParty = $root->createElement('cac:SignatoryParty');
        $signature->appendChild($signatoryParty);
        // inicio de nodo cac PartyIdentification
        $partyIdentification = $root->createElement('cac:PartyIdentification');
        $signatoryParty->appendChild($partyIdentification);
        // inicio y fin de nod cbc ID
        $id = $root->createElement('cbc:ID','RUC del emisor');
        $partyIdentification->appendChild($id);
        // inicio de nod cac PartyName
        $partyName = $root->createElement('cac:PartyName');
        $signatoryParty->appendChild($partyName);
        // inicio de nodo cbc Name
        $name = $root->createElement('cbc:Name','nombre comercial del emisor');
        $partyName->appendChild($name);
        // fin de nodo cac SignatoryParty

        // inicio de nodo cac DigitalSignatureAttachment
        $digitalSignatureAttachment = $root->createElement('cac:DigitalSignatureAttachment');
        $signature->appendChild($digitalSignatureAttachment);
        // inicio de nodo cac ExternalReference
        $externalReference = $root->createElement('cac:ExternalReference');
        $digitalSignatureAttachment->appendChild($externalReference);
        // inicio y fin de nodo cbc URI
        $uri = $root->createElement('cbc:URI','#SignatureSP');
        $externalReference->appendChild($uri);
        // fin de nodo cac ExternalReference
        // fin de nodo cac DigitalSignatureAttachment
        // fin de nodo cac Signature
        
        // inicio de nodo cac AccountingSupplierParty
        $accountingSupplierParty = $root->createElement('cac:AccountingSupplierParty');
        $xml->appendChild($accountingSupplierParty);
            // inicio de nodo cac Party
            $party = $root->createElement('cac:Party');
            $accountingSupplierParty->appendChild($party);
                // inicio de nodo cac PartyName
                $partyName = $root->createElement('cac:PartyName');
                $accountingSupplierParty->appendChild($partyName);
                    // inicio y fin de nodo cbc Name
                    $name = $root->createElement('cbc:Name','Nombre Comercial del emisor');
                    $party->appendChild($name);
                // fin de nodo cac PartyName

                // inicio de nodo cac PartyTaxScheme
                $partyTaxScheme = $root->createElement('cac:PartyTaxScheme');
                $party->appendChild($partyTaxScheme);
                    // inicio de nodo cbc RegistrationName
                    $registrationName = $root->createElement('cbc:RegistrationName','<![CDATA[NOMBRE COMERCIAL DEL EMISOR]]>');
                    $partyTaxScheme->appendChild($registrationName);
                    // fin de nodo cbc RegistrationName

                    // inicio de nodo CompanyID --- 6 = RUC
                    $companyID = $root->createElement('CompanyID','RUC DEL EMISOR');
                    $partyTaxScheme->appendChild($companyID);
                    $companyID->setAttribute('schemeID','6');
                    $companyID->setAttribute('schemeName','SUNAT:Identificador de Documento de Identidad');
                    $companyID->setAttribute('schemeAgencyName','PE:SUNAT');
                    $companyID->setAttribute('schemeURI','urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06');
                    // fin de nodo CompanyID

                    // inicio de nodo cac RegistrationAddress
                    $registrationAddress = $root->createElement('cac:RegistrationAddress');
                    $partyTaxScheme->appendChild($registrationAddress);
                        // inicio y fin de nodo cbc AddressTypeCode
                        $addressTypeCode = $root->createElement('AddressTypeCode','0000');
                    // fin de nodo cac RegistrationAddress

                    // inicio de nodo cac TaxScheme
                    $taxScheme = $root->createElement('cac:TaxScheme');
                    $partyTaxScheme->appendChild($taxScheme);
                        // inicio y fin de nodo cbc ID
                        $id = $root->createElement('cbc:ID','-');
                    // fin de nodo cac TaxScheme
                // fin de nodo cac PartyTaxScheme
            // fin de nodo cac Party
        // fin de nodo cac AccountingSupplierParty
        


        // END INFORMACION DE DOCUMENTO ELECTRONICO




        // Recorre los datos y agrega los elementos al XML
        // foreach ($data as $key => $value) {
        //     $xml->appendChild($key, $value);
        // }

        // Convierte el objeto SimpleXMLElement a una cadena XML
        $xmlString = $root->saveXML();

        // Elimina las etiquetas XML innecesarias agregadas por SimpleXMLElement
        // $xmlString = $this->removeXmlTags($xmlString);

        // Retorna el XML limpio y válido
        return $xmlString;
    }

    private function removeXmlTags($xmlString)
    {
        // Elimina las etiquetas XML innecesarias
        $tagsToRemove = ['<?xml version="1.0" encoding="UTF-8"?>', "\n"];
        $xmlString = str_replace($tagsToRemove, '', $xmlString);

        return trim($xmlString);
    }
}
