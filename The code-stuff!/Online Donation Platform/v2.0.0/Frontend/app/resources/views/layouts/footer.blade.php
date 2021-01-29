<footer>
	<div class='container justify-content-between px-0 py-3 public_page'>
		<div class='row'>
			<div class='col-6 py-3'>
				<p class='footer_logo'></p>
				<p>&copy; {{ date('Y', time()) }} DashDonate.org</p>
				<p>All rights reserved</p>
				<br/>
				<p>Castle Holdings Group Ltd t/a DashDonate.org</p>
				<p>Company No. 12088261</p>
			</div>
			<div class='col-6 py-3 text-right'>
				<p class='socials text-right'>
					<a href='https://www.facebook.com/dashdonate/' target='_blank'><i class='fab fa-facebook'></i></a>
					<a href='https://twitter.com/dashdonate' target='_blank'><i class='fab fa-twitter'></i></a>
					<a href='https://www.instagram.com/dashdonate/' target='_blank'><i class='fab fa-instagram'></i></a>
					<a href='https://www.linkedin.com/company/dashdonate/' target='_blank'><i class='fab fa-linkedin'></i></a>
				</p>
				</br>
				<p>Get in touch</p>
				<p class='opa-1'><a href='mailto:team@dashdonate.org' class='email_link' target='_blank'>team@dashdonate.org</a></p>
				<br/>
				<p>
					<a href='{{ route('public-legal-terms') }}' target='_blank'>Terms of Service</a> &nbsp;&bull;&nbsp;
					<a href='{{ route('public-legal-privacy') }}' target='_blank'>Privacy Policy</a>
					</br>
					<a href='{{ route('public-legal-cookies') }}' target='_blank'>Cookie Policy</a> &nbsp;&bull;&nbsp;
					<a href='{{ route('public-legal-terms_for_charities') }}' target='_blank'>Terms for Charities</a>
				</p>
			</div>
		</div>
	</div>
</footer>
