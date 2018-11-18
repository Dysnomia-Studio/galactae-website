using Galactae_website.Models;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Localization;
using System.Diagnostics;

namespace Galactae_website.Controllers {
	public class HomeController:Controller {
		public IStringLocalizer<HomeController> _localizer;
		public HomeController(IStringLocalizer<HomeController> localizer) {
			_localizer = localizer;
		}

		[Route("/")]
		[Route("index")]
		public IActionResult Index() {
			return View();
		}

		[Route("contact")]
		public IActionResult Contact() {
			return View();
		}

		[ResponseCache(Duration = 0, Location = ResponseCacheLocation.None, NoStore = true)]
		public IActionResult Error() {
			return View(new ErrorViewModel { RequestId = Activity.Current?.Id ?? HttpContext.TraceIdentifier });
		}
	}
}
