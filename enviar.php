<?php

// Obtener los datos del formulario (ejemplo)
$nombre = $_POST['nombre'];
$proyecto = $_POST['proyecto'];
$avance = $_POST['avance'];

// Crear el objeto SimpleXMLElement
$xml = new SimpleXMLElement('<user></user>');

// Agregar datos al XML (personaliza según tus necesidades)
$xml->addChild('name', htmlspecialchars($nombre));
$xml->addChild('proyecto', htmlspecialchars($proyecto));
$xml->addChild('avance', htmlspecialchars($avance));

// Formatear el XML
$dom = new DOMDocument();
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($xml->asXML());

// Convertir el XML a base64
$xml_base64 = base64_encode($dom->saveXML());
$xml->asXML('archivoMauricios.xml');

// Configurar los datos para enviar
$data = [
    'xml_data' => $xml
];

// URL del servidor receptor
$url = 'http://faoservice.econotec.com.bo/upload-file';

// Inicializar cURL
$ch = curl_init();

// Configurar las opciones de cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded'
]);

// Ejecutar la petición y verificar errores
if (curl_exec($ch) === false) {
    echo 'Error al enviar el XML: ' . curl_error($ch);
} else {
    echo 'XML enviado correctamente.';
}

// Cerrar cURL
curl_close($ch);
?>