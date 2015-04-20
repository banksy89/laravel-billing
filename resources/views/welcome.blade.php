<html>
	<head>
		<title>Laravel</title>
		
		<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #B0BEC5;
				display: table;
				font-weight: 100;
				font-family: 'Lato';
			}

			.container {
				text-align: center;
				display: table-cell;
				vertical-align: middle;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
				font-size: 96px;
				margin-bottom: 40px;
			}

			.quote {
				font-size: 24px;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div class="title">Stripe Card Subscription</div>
				<form method="post" action="/add" id="subscription-form">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<label for="number">Credit card number</label>
					<input type="number" name="number" data-stripe="number"  id="number" />

					<label for="cvc">CVC</label>
					<input type="cvc" name="cvc" data-stripe="cvc"  id="cvc" />

					<p>
						<label for="exp_month">Expiry Month</label>
						<input type="number" name="exp_month" data-stripe="exp_month"  id="exp_month" />

						<label for="exp_year">Expiry Year</label>
						<input type="number" name="exp_year" data-stripe="exp_year"  id="exp_year" />
					</p>
					<input type="submit" value="Go!" />
				</form>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
			<script>
			Stripe.setPublishableKey('{{ env("STRIPE_API_PUB_SECRET") }}');
				jQuery(function($) {
					$('#subscription-form').submit(function(event) {
						
					    var $form = $(this);
					    $form.find('button').prop('disabled', true);

					    console.log($form)

					    Stripe.card.createToken($form, stripeResponseHandler);

					    return false;
					});
			});

			var stripeResponseHandler = function(status, response) {
			var $form = $('#subscription-form');
			console.log(status, response)
			if (response.error) {
			    $form.find('.payment-errors').text(response.error.message);
			    $form.find('button').prop('disabled', false);
			} else {
			    var token = response.id;
				    $form.append($('<input type="hidden" name="stripeToken" />').val(token));
				    $form.get(0).submit();
				}
			};
		</script>
	</body>
</html>
