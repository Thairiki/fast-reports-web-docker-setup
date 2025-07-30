using FastReport;
using FastReport.Export.PdfSimple;
using Microsoft.AspNetCore.Mvc;
using System.IO;

[ApiController]
[Route("api/reports")]
public class ReportsController : ControllerBase
{
    [HttpPost("generate")]
    public IActionResult GenerateReport()
    {
        try
        {
            var report = new Report();
            // Load .frx file from disk
            report.Load("reports/report.frx");
            report.Prepare();

            using var memoryStream = new MemoryStream();
            var pdfExport = new PDFSimpleExport();
            pdfExport.Export(report, memoryStream);
            memoryStream.Position = 0;

            return File(memoryStream.ToArray(), "application/pdf", "report.pdf");
        }
        catch (Exception ex)
        {
            return BadRequest($"Error: {ex.Message}");
        }
    }
}