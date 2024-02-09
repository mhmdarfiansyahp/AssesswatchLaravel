<title>{{ pathinfo($detailSertifikasi->buktipendukung, PATHINFO_FILENAME) }}</title>
<body style="margin: 0; padding: 0;">
    <div class="pdf-container" style="width: 100vw; height: 100vh;">
        <embed class="pdf-content" src="data:application/pdf;base64,{{ base64_encode($pdfContent) }}" type="application/pdf" style="width: 100%; height: 100%;" />
    </div>
</body>
</html>
