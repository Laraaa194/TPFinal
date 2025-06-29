document.querySelector('.descargar-btn').addEventListener('click', async () => {
    const elemento = document.getElementById('contenido-pdf');

    await new Promise(resolve => setTimeout(resolve, 300));

    const canvas = await html2canvas(elemento, { scale: 4, useCORS: true });
    const imgData = canvas.toDataURL('image/png');

    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF('p', 'mm', 'a4');
    const pdfWidth = pdf.internal.pageSize.getWidth();
    const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

    pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
    pdf.save("reporte.pdf");
});

document.querySelector('.imprimir-btn').addEventListener('click', () => {
    window.print();
});