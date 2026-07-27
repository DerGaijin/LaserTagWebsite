<?php
$page = [
	'shell' => 'flex flex-col items-center px-[100px] py-[25px] max-[1260px]:px-[15px] max-[775px]:px-[5px]',
	'section' => 'w-full max-w-[1180px]',
	'panel' => 'rounded-[25px] bg-[var(--ContentBoxBackground)] shadow-[10px_10px_20px_black]',
	'card' => 'flex items-center justify-between gap-3 rounded-xl border border-white/10 bg-black/25 px-3 py-2',
];
?>
<!DOCTYPE html>
<html lang="de">

<head>
	<?php require '../resources/head.php'; ?>
</head>

<body>
	<?php include '../resources/header.php'; ?>

	<main class="<?= $page['shell'] ?>">
		<section class="<?= $page['section'] ?> <?= $page['panel'] ?> mt-6 border border-white/10 p-4 max-[775px]:p-3">
			<h1 class="text-[22px] leading-tight text-[#73ffff] max-[775px]:text-[20px]">User Access Token Test</h1>

			<form id="user-access-token-test"
				class="mt-4 grid grid-cols-[1fr_1fr_1fr_auto] gap-2 font-[Arial,Helvetica,sans-serif] text-sm max-[760px]:grid-cols-1">
				<div class="<?= $page['card'] ?>">
					<p class="text-xs uppercase tracking-[0.12em] text-white/60">Status</p>
					<p data-user-token-status class="text-[#73ffff]">Not run</p>
				</div>
				<div class="<?= $page['card'] ?>">
					<p class="text-xs uppercase tracking-[0.12em] text-white/60">Tested At</p>
					<p data-user-token-tested-at class="text-[#73ffff]">-</p>
				</div>
				<div class="<?= $page['card'] ?>">
					<p class="text-xs uppercase tracking-[0.12em] text-white/60">Duration</p>
					<p data-user-token-duration class="text-[#73ffff]">-</p>
				</div>
				<button class="Button_Book px-5 py-2 text-sm" type="submit">Run</button>
			</form>

			<div data-user-token-error-box
				class="mt-4 hidden rounded-2xl border border-red-400/60 bg-red-950/30 p-3 font-[Arial,Helvetica,sans-serif] text-sm text-red-100">
				<p class="text-xs uppercase tracking-[0.12em]">Error Detail</p>
				<p data-user-token-error class="mt-1 leading-5"></p>
			</div>

			<div data-user-token-detail-box
				class="mt-4 hidden rounded-2xl border border-green-300/50 bg-green-950/20 p-3 font-[Arial,Helvetica,sans-serif] text-sm text-green-100">
				<p class="text-xs uppercase tracking-[0.12em]">Token Detail</p>
				<p data-user-token-detail class="mt-1 leading-5"></p>
			</div>
		</section>

		<section class="<?= $page['section'] ?> <?= $page['panel'] ?> mt-6 border border-white/10 p-4 max-[775px]:p-3">
			<h1 class="text-[22px] leading-tight text-[#73ffff] max-[775px]:text-[20px]">Admin Access Token Test</h1>

			<form id="admin-access-token-test"
				class="mt-4 grid grid-cols-[1fr_1fr_1fr_auto] gap-2 font-[Arial,Helvetica,sans-serif] text-sm max-[760px]:grid-cols-1">
				<div class="<?= $page['card'] ?>">
					<p class="text-xs uppercase tracking-[0.12em] text-white/60">Status</p>
					<p data-admin-token-status class="text-[#73ffff]">Not run</p>
				</div>
				<div class="<?= $page['card'] ?>">
					<p class="text-xs uppercase tracking-[0.12em] text-white/60">Tested At</p>
					<p data-admin-token-tested-at class="text-[#73ffff]">-</p>
				</div>
				<div class="<?= $page['card'] ?>">
					<p class="text-xs uppercase tracking-[0.12em] text-white/60">Duration</p>
					<p data-admin-token-duration class="text-[#73ffff]">-</p>
				</div>
				<button class="Button_Book px-5 py-2 text-sm" type="submit">Run</button>
			</form>

			<div data-admin-token-error-box
				class="mt-4 hidden rounded-2xl border border-red-400/60 bg-red-950/30 p-3 font-[Arial,Helvetica,sans-serif] text-sm text-red-100">
				<p class="text-xs uppercase tracking-[0.12em]">Error Detail</p>
				<p data-admin-token-error class="mt-1 leading-5"></p>
			</div>

			<div data-admin-token-detail-box
				class="mt-4 hidden rounded-2xl border border-green-300/50 bg-green-950/20 p-3 font-[Arial,Helvetica,sans-serif] text-sm text-green-100">
				<p class="text-xs uppercase tracking-[0.12em]">Token Detail</p>
				<p data-admin-token-detail class="mt-1 leading-5"></p>
			</div>
		</section>

		<section class="<?= $page['section'] ?> <?= $page['panel'] ?> mt-6 border border-white/10 p-4 max-[775px]:p-3">
			<h1 class="text-[22px] leading-tight text-[#73ffff] max-[775px]:text-[20px]">Services Test</h1>

			<form id="services-test"
				class="mt-4 grid grid-cols-[1fr_1fr_1fr_auto] gap-2 font-[Arial,Helvetica,sans-serif] text-sm max-[760px]:grid-cols-1">
				<div class="<?= $page['card'] ?>">
					<p class="text-xs uppercase tracking-[0.12em] text-white/60">Status</p>
					<p data-services-status class="text-[#73ffff]">Not run</p>
				</div>
				<div class="<?= $page['card'] ?>">
					<p class="text-xs uppercase tracking-[0.12em] text-white/60">Tested At</p>
					<p data-services-tested-at class="text-[#73ffff]">-</p>
				</div>
				<div class="<?= $page['card'] ?>">
					<p class="text-xs uppercase tracking-[0.12em] text-white/60">Duration</p>
					<p data-services-duration class="text-[#73ffff]">-</p>
				</div>
				<button class="Button_Book px-5 py-2 text-sm" type="submit">Run</button>
			</form>

			<div data-services-error-box
				class="mt-4 hidden rounded-2xl border border-red-400/60 bg-red-950/30 p-3 font-[Arial,Helvetica,sans-serif] text-sm text-red-100">
				<p class="text-xs uppercase tracking-[0.12em]">Error Detail</p>
				<p data-services-error class="mt-1 leading-5"></p>
			</div>

			<div data-services-table-box
				class="mt-4 hidden overflow-x-auto rounded-2xl border border-white/10 bg-black/25 font-[Arial,Helvetica,sans-serif] text-sm">
				<table class="w-full min-w-[640px] border-collapse text-left">
					<thead class="border-b border-white/10 text-xs uppercase tracking-[0.12em] text-white/60">
						<tr>
							<th class="px-3 py-2 font-normal">ID</th>
							<th class="px-3 py-2 font-normal">Name</th>
							<th class="px-3 py-2 font-normal">Duration</th>
							<th class="px-3 py-2 font-normal">Visible</th>
						</tr>
					</thead>
					<tbody data-services-table-body class="divide-y divide-white/10"></tbody>
				</table>
			</div>

			<details data-services-raw-box
				class="mt-4 hidden rounded-2xl border border-white/10 bg-black/35 p-3 font-[Arial,Helvetica,sans-serif] text-sm text-white/85">
				<summary class="cursor-pointer text-[#73ffff]">Raw service response</summary>
				<pre data-services-raw class="mt-3 max-h-[520px] overflow-auto whitespace-pre-wrap text-xs leading-5"></pre>
			</details>
		</section>

		<section class="<?= $page['section'] ?> <?= $page['panel'] ?> mt-6 border border-white/10 p-4 max-[775px]:p-3">
			<h1 class="text-[22px] leading-tight text-[#73ffff] max-[775px]:text-[20px]">Availability Test</h1>

			<form id="availability-test"
				class="mt-4 grid grid-cols-[1fr_1fr_1fr_auto] gap-2 font-[Arial,Helvetica,sans-serif] text-sm max-[760px]:grid-cols-1">
				<div class="<?= $page['card'] ?>">
					<p class="text-xs uppercase tracking-[0.12em] text-white/60">Status</p>
					<p data-availability-status class="text-[#73ffff]">Not run</p>
				</div>
				<div class="<?= $page['card'] ?>">
					<p class="text-xs uppercase tracking-[0.12em] text-white/60">Tested At</p>
					<p data-availability-tested-at class="text-[#73ffff]">-</p>
				</div>
				<div class="<?= $page['card'] ?>">
					<p class="text-xs uppercase tracking-[0.12em] text-white/60">Duration</p>
					<p data-availability-duration class="text-[#73ffff]">-</p>
				</div>
				<button class="Button_Book px-5 py-2 text-sm" type="submit">Run</button>
			</form>

			<div
				class="mt-4 grid grid-cols-5 gap-2 font-[Arial,Helvetica,sans-serif] text-sm max-[1100px]:grid-cols-2 max-[560px]:grid-cols-1">
				<label class="flex flex-col gap-1 text-white/75">
					<span class="text-xs uppercase tracking-[0.12em] text-white/60">Service ID</span>
					<input
						class="rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-white outline-none focus:border-[#73ffff]"
						data-availability-service-id type="number" min="1" step="1" value="20">
				</label>
				<label class="flex flex-col gap-1 text-white/75">
					<span class="text-xs uppercase tracking-[0.12em] text-white/60">From Day</span>
					<input
						class="rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-white outline-none focus:border-[#73ffff]"
						data-availability-from-date type="text" inputmode="numeric" placeholder="TT.MM.JJJJ" value="20.08.2026">
				</label>
				<label class="flex flex-col gap-1 text-white/75">
					<span class="text-xs uppercase tracking-[0.12em] text-white/60">To Day</span>
					<input
						class="rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-white outline-none focus:border-[#73ffff]"
						data-availability-to-date type="text" inputmode="numeric" placeholder="TT.MM.JJJJ" value="20.08.2026">
				</label>
				<label class="flex flex-col gap-1 text-white/75">
					<span class="text-xs uppercase tracking-[0.12em] text-white/60">Performer ID</span>
					<input
						class="rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-white outline-none focus:border-[#73ffff]"
						data-availability-performer-id type="number" min="1" step="1" placeholder="Optional">
				</label>
				<label class="flex flex-col gap-1 text-white/75">
					<span class="text-xs uppercase tracking-[0.12em] text-white/60">Count</span>
					<input
						class="rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-white outline-none focus:border-[#73ffff]"
						data-availability-count type="number" min="1" step="1" value="1">
				</label>
			</div>

			<div data-availability-error-box
				class="mt-4 hidden rounded-2xl border border-red-400/60 bg-red-950/30 p-3 font-[Arial,Helvetica,sans-serif] text-sm text-red-100">
				<p class="text-xs uppercase tracking-[0.12em]">Error Detail</p>
				<p data-availability-error class="mt-1 leading-5"></p>
			</div>

			<div data-availability-slots-box
				class="mt-4 hidden rounded-2xl border border-white/10 bg-black/35 p-3 font-[Arial,Helvetica,sans-serif] text-sm text-white/85">
				<p><span class="text-white/60">Available slots:</span> <span data-availability-slot-count class="text-[#73ffff]">0</span></p>
				<div data-availability-slots class="mt-3 flex flex-wrap gap-2"></div>
			</div>

			<details data-availability-raw-box
				class="mt-4 hidden rounded-2xl border border-white/10 bg-black/35 p-3 font-[Arial,Helvetica,sans-serif] text-sm text-white/85">
				<summary class="cursor-pointer text-[#73ffff]">Raw availability response</summary>
				<pre data-availability-raw class="mt-3 max-h-[520px] overflow-auto whitespace-pre-wrap text-xs leading-5"></pre>
			</details>
		</section>

		<section class="<?= $page['section'] ?> <?= $page['panel'] ?> mt-6 border border-white/10 p-4 max-[775px]:p-3">
			<h1 class="text-[22px] leading-tight text-[#73ffff] max-[775px]:text-[20px]">User Login Test</h1>

			<form id="user-login-test"
				class="mt-4 grid grid-cols-[1fr_1fr_1fr_auto] gap-2 font-[Arial,Helvetica,sans-serif] text-sm max-[760px]:grid-cols-1">
				<div class="<?= $page['card'] ?>">
					<p class="text-xs uppercase tracking-[0.12em] text-white/60">Status</p>
					<p data-user-login-status class="text-[#73ffff]">Not run</p>
				</div>
				<div class="<?= $page['card'] ?>">
					<p class="text-xs uppercase tracking-[0.12em] text-white/60">Tested At</p>
					<p data-user-login-tested-at class="text-[#73ffff]">-</p>
				</div>
				<div class="<?= $page['card'] ?>">
					<p class="text-xs uppercase tracking-[0.12em] text-white/60">Duration</p>
					<p data-user-login-duration class="text-[#73ffff]">-</p>
				</div>
				<button class="Button_Book px-5 py-2 text-sm" type="submit">Run</button>
			</form>

			<div class="mt-4 grid grid-cols-2 gap-2 font-[Arial,Helvetica,sans-serif] text-sm max-[560px]:grid-cols-1">
				<label class="flex flex-col gap-1 text-white/75">
					<span class="text-xs uppercase tracking-[0.12em] text-white/60">Email</span>
					<input
						class="rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-white outline-none focus:border-[#73ffff]"
						data-user-login-login type="email" placeholder="user@example.com">
				</label>
				<label class="flex flex-col gap-1 text-white/75">
					<span class="text-xs uppercase tracking-[0.12em] text-white/60">Password</span>
					<input
						class="rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-white outline-none focus:border-[#73ffff]"
						data-user-login-password type="password" placeholder="Password">
				</label>
			</div>

			<div data-user-login-error-box
				class="mt-4 hidden rounded-2xl border border-red-400/60 bg-red-950/30 p-3 font-[Arial,Helvetica,sans-serif] text-sm text-red-100">
				<p class="text-xs uppercase tracking-[0.12em]">Error Detail</p>
				<p data-user-login-error class="mt-1 leading-5"></p>
			</div>

			<div data-user-login-detail-box
				class="mt-4 hidden rounded-2xl border border-green-300/50 bg-green-950/20 p-3 font-[Arial,Helvetica,sans-serif] text-sm text-green-100">
				<p class="text-xs uppercase tracking-[0.12em]">Login Detail</p>
				<p data-user-login-detail class="mt-1 leading-5"></p>
			</div>

			<details data-user-login-raw-box
				class="mt-4 hidden rounded-2xl border border-white/10 bg-black/35 p-3 font-[Arial,Helvetica,sans-serif] text-sm text-white/85">
				<summary class="cursor-pointer text-[#73ffff]">Raw login response</summary>
				<pre data-user-login-raw class="mt-3 max-h-[520px] overflow-auto whitespace-pre-wrap text-xs leading-5"></pre>
			</details>
		</section>

		<section class="<?= $page['section'] ?> <?= $page['panel'] ?> mt-6 border border-white/10 p-4 max-[775px]:p-3">
			<h1 class="text-[22px] leading-tight text-[#73ffff] max-[775px]:text-[20px]">User Registration Test</h1>

			<form id="user-registration-test"
				class="mt-4 grid grid-cols-[1fr_1fr_1fr_auto] gap-2 font-[Arial,Helvetica,sans-serif] text-sm max-[760px]:grid-cols-1">
				<div class="<?= $page['card'] ?>">
					<p class="text-xs uppercase tracking-[0.12em] text-white/60">Status</p>
					<p data-user-registration-status class="text-[#73ffff]">Not run</p>
				</div>
				<div class="<?= $page['card'] ?>">
					<p class="text-xs uppercase tracking-[0.12em] text-white/60">Tested At</p>
					<p data-user-registration-tested-at class="text-[#73ffff]">-</p>
				</div>
				<div class="<?= $page['card'] ?>">
					<p class="text-xs uppercase tracking-[0.12em] text-white/60">Duration</p>
					<p data-user-registration-duration class="text-[#73ffff]">-</p>
				</div>
				<button class="Button_Book px-5 py-2 text-sm" type="submit">Run</button>
			</form>

			<div class="mt-4 grid grid-cols-4 gap-2 font-[Arial,Helvetica,sans-serif] text-sm max-[920px]:grid-cols-2 max-[560px]:grid-cols-1">
				<label class="flex flex-col gap-1 text-white/75">
					<span class="text-xs uppercase tracking-[0.12em] text-white/60">Name</span>
					<input
						class="rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-white outline-none focus:border-[#73ffff]"
						data-user-registration-name type="text" placeholder="Test User">
				</label>
				<label class="flex flex-col gap-1 text-white/75">
					<span class="text-xs uppercase tracking-[0.12em] text-white/60">Phone</span>
					<input
						class="rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-white outline-none focus:border-[#73ffff]"
						data-user-registration-phone type="tel" placeholder="+491234567890">
				</label>
				<label class="flex flex-col gap-1 text-white/75">
					<span class="text-xs uppercase tracking-[0.12em] text-white/60">Email</span>
					<input
						class="rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-white outline-none focus:border-[#73ffff]"
						data-user-registration-email type="email" placeholder="new-user@example.com">
				</label>
				<label class="flex flex-col gap-1 text-white/75">
					<span class="text-xs uppercase tracking-[0.12em] text-white/60">Password</span>
					<input
						class="rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-white outline-none focus:border-[#73ffff]"
						data-user-registration-password type="password" placeholder="Password">
				</label>
			</div>

			<div data-user-registration-error-box
				class="mt-4 hidden rounded-2xl border border-red-400/60 bg-red-950/30 p-3 font-[Arial,Helvetica,sans-serif] text-sm text-red-100">
				<p class="text-xs uppercase tracking-[0.12em]">Error Detail</p>
				<p data-user-registration-error class="mt-1 leading-5"></p>
			</div>

			<div data-user-registration-detail-box
				class="mt-4 hidden rounded-2xl border border-green-300/50 bg-green-950/20 p-3 font-[Arial,Helvetica,sans-serif] text-sm text-green-100">
				<p class="text-xs uppercase tracking-[0.12em]">Registration Detail</p>
				<p data-user-registration-detail class="mt-1 leading-5"></p>
			</div>

			<details data-user-registration-raw-box
				class="mt-4 hidden rounded-2xl border border-white/10 bg-black/35 p-3 font-[Arial,Helvetica,sans-serif] text-sm text-white/85">
				<summary class="cursor-pointer text-[#73ffff]">Raw registration response</summary>
				<pre data-user-registration-raw class="mt-3 max-h-[520px] overflow-auto whitespace-pre-wrap text-xs leading-5"></pre>
			</details>
		</section>

		<section class="<?= $page['section'] ?> <?= $page['panel'] ?> mt-6 border border-white/10 p-4 max-[775px]:p-3">
			<h1 class="text-[22px] leading-tight text-[#73ffff] max-[775px]:text-[20px]">Service Booking Test</h1>

			<form id="booking-test"
				class="mt-4 grid grid-cols-[1fr_1fr_1fr_auto] gap-2 font-[Arial,Helvetica,sans-serif] text-sm max-[760px]:grid-cols-1">
				<div class="<?= $page['card'] ?>">
					<p class="text-xs uppercase tracking-[0.12em] text-white/60">Status</p>
					<p data-booking-status class="text-[#73ffff]">Not run</p>
				</div>
				<div class="<?= $page['card'] ?>">
					<p class="text-xs uppercase tracking-[0.12em] text-white/60">Tested At</p>
					<p data-booking-tested-at class="text-[#73ffff]">-</p>
				</div>
				<div class="<?= $page['card'] ?>">
					<p class="text-xs uppercase tracking-[0.12em] text-white/60">Duration</p>
					<p data-booking-duration class="text-[#73ffff]">-</p>
				</div>
				<button class="Button_Book px-5 py-2 text-sm" type="submit">Run</button>
			</form>

			<div
				class="mt-4 grid grid-cols-4 gap-2 font-[Arial,Helvetica,sans-serif] text-sm max-[920px]:grid-cols-2 max-[560px]:grid-cols-1">
				<label class="flex flex-col gap-1 text-white/75">
					<span class="text-xs uppercase tracking-[0.12em] text-white/60">Service ID</span>
					<input
						class="rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-white outline-none focus:border-[#73ffff]"
						data-booking-service-id type="number" min="1" step="1" value="20">
				</label>
				<label class="flex flex-col gap-1 text-white/75">
					<span class="text-xs uppercase tracking-[0.12em] text-white/60">Performer ID</span>
					<input
						class="rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-white outline-none focus:border-[#73ffff]"
						data-booking-performer-id type="number" min="1" step="1" placeholder="Required" value="1">
				</label>
				<label class="flex flex-col gap-1 text-white/75">
					<span class="text-xs uppercase tracking-[0.12em] text-white/60">Date (DD.MM.YYYY)</span>
					<input
						class="rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-white outline-none focus:border-[#73ffff]"
						data-booking-date type="text" inputmode="numeric" placeholder="TT.MM.JJJJ" value="20.08.2026">
				</label>
				<label class="flex flex-col gap-1 text-white/75">
					<span class="text-xs uppercase tracking-[0.12em] text-white/60">Time</span>
					<input
						class="rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-white outline-none focus:border-[#73ffff]"
						data-booking-time type="time" value="15:00">
				</label>
				<label class="flex flex-col gap-1 text-white/75">
					<span class="text-xs uppercase tracking-[0.12em] text-white/60">Count</span>
					<input
						class="rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-white outline-none focus:border-[#73ffff]"
						data-booking-count type="number" min="1" step="1" value="1">
				</label>
				<label class="flex flex-col gap-1 text-white/75">
					<span class="text-xs uppercase tracking-[0.12em] text-white/60">Client Name</span>
					<input
						class="rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-white outline-none focus:border-[#73ffff]"
						data-booking-client-name type="text" placeholder="Test User">
				</label>
				<label class="flex flex-col gap-1 text-white/75">
					<span class="text-xs uppercase tracking-[0.12em] text-white/60">Client Email</span>
					<input
						class="rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-white outline-none focus:border-[#73ffff]"
						data-booking-client-email type="email" placeholder="test@example.com">
				</label>
				<label class="flex flex-col gap-1 text-white/75">
					<span class="text-xs uppercase tracking-[0.12em] text-white/60">Client Phone</span>
					<input
						class="rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-white outline-none focus:border-[#73ffff]"
						data-booking-client-phone type="tel" placeholder="+491234567890">
				</label>
				<label class="flex flex-col gap-1 text-white/75">
					<span class="text-xs uppercase tracking-[0.12em] text-white/60">Client Password</span>
					<input
						class="rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-white outline-none focus:border-[#73ffff]"
						data-booking-client-password type="password" placeholder="Password">
				</label>
			</div>

			<div data-booking-error-box
				class="mt-4 hidden rounded-2xl border border-red-400/60 bg-red-950/30 p-3 font-[Arial,Helvetica,sans-serif] text-sm text-red-100">
				<p class="text-xs uppercase tracking-[0.12em]">Error Detail</p>
				<p data-booking-error class="mt-1 leading-5"></p>
			</div>

			<div data-booking-detail-box
				class="mt-4 hidden rounded-2xl border border-green-300/50 bg-green-950/20 p-3 font-[Arial,Helvetica,sans-serif] text-sm text-green-100">
				<p class="text-xs uppercase tracking-[0.12em]">Booking Detail</p>
				<p data-booking-detail class="mt-1 leading-5"></p>
			</div>

			<details data-booking-raw-box
				class="mt-4 hidden rounded-2xl border border-white/10 bg-black/35 p-3 font-[Arial,Helvetica,sans-serif] text-sm text-white/85">
				<summary class="cursor-pointer text-[#73ffff]">Raw booking response</summary>
				<pre data-booking-raw class="mt-3 max-h-[520px] overflow-auto whitespace-pre-wrap text-xs leading-5"></pre>
			</details>
		</section>
	</main>

	<script>
		(() => {
			const form = document.querySelector('#user-access-token-test');
			if (!form) return;

			const status = document.querySelector('[data-user-token-status]');
			const testedAt = document.querySelector('[data-user-token-tested-at]');
			const duration = document.querySelector('[data-user-token-duration]');
			const errorBox = document.querySelector('[data-user-token-error-box]');
			const error = document.querySelector('[data-user-token-error]');
			const detailBox = document.querySelector('[data-user-token-detail-box]');
			const detail = document.querySelector('[data-user-token-detail]');
			const button = form.querySelector('button[type="submit"]');
			const pagePath = window.location.pathname;
			const userTokenUrl = pagePath.endsWith('/')
				? `${pagePath}UserToken.php`
				: `${pagePath.replace(/\/index\.php$/i, '')}/UserToken.php`;

			form.addEventListener('submit', async (event) => {
				event.preventDefault();

				status.textContent = 'Running';
				status.className = 'text-[#73ffff]';
				testedAt.textContent = '-';
				duration.textContent = '-';
				errorBox.classList.add('hidden');
				detailBox.classList.add('hidden');
				button.disabled = true;

				try {
					const response = await fetch(userTokenUrl, { method: 'POST' });
					const contentType = response.headers.get('content-type') || '';

					if (!contentType.includes('application/json')) {
						const text = await response.text();
						throw new Error(`Expected JSON from ${userTokenUrl}, received ${contentType || 'unknown content type'}: ${text.slice(0, 120)}`);
					}

					const data = await response.json();

					status.textContent = data.status || (data.ok ? 'Passed' : 'Failed');
					status.className = data.ok ? 'text-green-300' : 'text-red-200';
					testedAt.textContent = data.testedAt || '-';
					duration.textContent = data.duration || '-';

					if (data.ok) {
						detail.textContent = data.detail || '';
						detailBox.classList.remove('hidden');
					} else {
						error.textContent = data.error || 'User token request failed.';
						errorBox.classList.remove('hidden');
					}
				} catch (exception) {
					status.textContent = 'Failed';
					status.className = 'text-red-200';
					error.textContent = exception instanceof Error ? exception.message : 'User token request failed.';
					errorBox.classList.remove('hidden');
				} finally {
					button.disabled = false;
				}
			});
		})();

		(() => {
			const form = document.querySelector('#admin-access-token-test');
			if (!form) return;

			const status = document.querySelector('[data-admin-token-status]');
			const testedAt = document.querySelector('[data-admin-token-tested-at]');
			const duration = document.querySelector('[data-admin-token-duration]');
			const errorBox = document.querySelector('[data-admin-token-error-box]');
			const error = document.querySelector('[data-admin-token-error]');
			const detailBox = document.querySelector('[data-admin-token-detail-box]');
			const detail = document.querySelector('[data-admin-token-detail]');
			const button = form.querySelector('button[type="submit"]');
			const pagePath = window.location.pathname;
			const adminTokenUrl = pagePath.endsWith('/')
				? `${pagePath}AdminToken.php`
				: `${pagePath.replace(/\/index\.php$/i, '')}/AdminToken.php`;

			form.addEventListener('submit', async (event) => {
				event.preventDefault();

				status.textContent = 'Running';
				status.className = 'text-[#73ffff]';
				testedAt.textContent = '-';
				duration.textContent = '-';
				errorBox.classList.add('hidden');
				detailBox.classList.add('hidden');
				button.disabled = true;

				try {
					const response = await fetch(adminTokenUrl, { method: 'POST' });
					const contentType = response.headers.get('content-type') || '';

					if (!contentType.includes('application/json')) {
						const text = await response.text();
						throw new Error(`Expected JSON from ${adminTokenUrl}, received ${contentType || 'unknown content type'}: ${text.slice(0, 120)}`);
					}

					const data = await response.json();

					status.textContent = data.status || (data.ok ? 'Passed' : 'Failed');
					status.className = data.ok ? 'text-green-300' : 'text-red-200';
					testedAt.textContent = data.testedAt || '-';
					duration.textContent = data.duration || '-';

					if (data.ok) {
						detail.textContent = data.detail || '';
						detailBox.classList.remove('hidden');
					} else {
						error.textContent = data.error || 'Admin token request failed.';
						errorBox.classList.remove('hidden');
					}
				} catch (exception) {
					status.textContent = 'Failed';
					status.className = 'text-red-200';
					error.textContent = exception instanceof Error ? exception.message : 'Admin token request failed.';
					errorBox.classList.remove('hidden');
				} finally {
					button.disabled = false;
				}
			});
		})();

		(() => {
			const form = document.querySelector('#services-test');
			if (!form) return;

			const status = document.querySelector('[data-services-status]');
			const testedAt = document.querySelector('[data-services-tested-at]');
			const duration = document.querySelector('[data-services-duration]');
			const errorBox = document.querySelector('[data-services-error-box]');
			const error = document.querySelector('[data-services-error]');
			const tableBox = document.querySelector('[data-services-table-box]');
			const tableBody = document.querySelector('[data-services-table-body]');
			const rawBox = document.querySelector('[data-services-raw-box]');
			const raw = document.querySelector('[data-services-raw]');
			const button = form.querySelector('button[type="submit"]');
			const pagePath = window.location.pathname;
			const servicesUrl = pagePath.endsWith('/')
				? `${pagePath}Services.php`
				: `${pagePath.replace(/\/index\.php$/i, '')}/Services.php`;

			const cell = (value) => {
				const td = document.createElement('td');
				td.className = 'px-3 py-2 text-white/85';
				td.textContent = value || '-';

				return td;
			};

			form.addEventListener('submit', async (event) => {
				event.preventDefault();

				status.textContent = 'Running';
				status.className = 'text-[#73ffff]';
				testedAt.textContent = '-';
				duration.textContent = '-';
				errorBox.classList.add('hidden');
				tableBox.classList.add('hidden');
				rawBox.classList.add('hidden');
				tableBody.replaceChildren();
				button.disabled = true;

				try {
					const response = await fetch(servicesUrl, { method: 'POST' });
					const contentType = response.headers.get('content-type') || '';

					if (!contentType.includes('application/json')) {
						const text = await response.text();
						throw new Error(`Expected JSON from ${servicesUrl}, received ${contentType || 'unknown content type'}: ${text.slice(0, 120)}`);
					}

					const data = await response.json();

					status.textContent = data.status || (data.ok ? 'Passed' : 'Failed');
					status.className = data.ok ? 'text-green-300' : 'text-red-200';
					testedAt.textContent = data.testedAt || '-';
					duration.textContent = data.duration || '-';

					if (!data.ok) {
						throw new Error(data.error || 'Services request failed.');
					}

					(data.services || []).forEach((service) => {
						const row = document.createElement('tr');
						row.append(cell(service.id), cell(service.name), cell(service.duration), cell(service.visible));
						tableBody.append(row);
					});

					if (!tableBody.children.length) {
						const row = document.createElement('tr');
						const empty = cell('No services returned.');
						empty.colSpan = 4;
						row.append(empty);
						tableBody.append(row);
					}

					raw.textContent = JSON.stringify(data.raw || data, null, 2);
					tableBox.classList.remove('hidden');
					rawBox.classList.remove('hidden');
				} catch (exception) {
					status.textContent = 'Failed';
					status.className = 'text-red-200';
					error.textContent = exception instanceof Error ? exception.message : 'Services request failed.';
					errorBox.classList.remove('hidden');
				} finally {
					button.disabled = false;
				}
			});
		})();

		(() => {
			const form = document.querySelector('#availability-test');
			if (!form) return;

			const status = document.querySelector('[data-availability-status]');
			const testedAt = document.querySelector('[data-availability-tested-at]');
			const duration = document.querySelector('[data-availability-duration]');
			const serviceId = document.querySelector('[data-availability-service-id]');
			const fromDate = document.querySelector('[data-availability-from-date]');
			const toDate = document.querySelector('[data-availability-to-date]');
			const performerId = document.querySelector('[data-availability-performer-id]');
			const count = document.querySelector('[data-availability-count]');
			const errorBox = document.querySelector('[data-availability-error-box]');
			const error = document.querySelector('[data-availability-error]');
			const slotsBox = document.querySelector('[data-availability-slots-box]');
			const slotCount = document.querySelector('[data-availability-slot-count]');
			const slots = document.querySelector('[data-availability-slots]');
			const rawBox = document.querySelector('[data-availability-raw-box]');
			const raw = document.querySelector('[data-availability-raw]');
			const button = form.querySelector('button[type="submit"]');
			const pagePath = window.location.pathname;
			const availabilityUrl = pagePath.endsWith('/')
				? `${pagePath}Availability.php`
				: `${pagePath.replace(/\/index\.php$/i, '')}/Availability.php`;

			form.addEventListener('submit', async (event) => {
				event.preventDefault();

				status.textContent = 'Running';
				status.className = 'text-[#73ffff]';
				testedAt.textContent = '-';
				duration.textContent = '-';
				errorBox.classList.add('hidden');
				slotsBox.classList.add('hidden');
				rawBox.classList.add('hidden');
				slots.replaceChildren();
				button.disabled = true;

				try {
					const response = await fetch(availabilityUrl, {
						method: 'POST',
						headers: { 'Content-Type': 'application/json' },
						body: JSON.stringify({
							serviceId: serviceId.value,
							fromDate: fromDate.value,
							toDate: toDate.value,
							performerId: performerId.value,
							count: count.value,
						}),
					});
					const contentType = response.headers.get('content-type') || '';

					if (!contentType.includes('application/json')) {
						const text = await response.text();
						throw new Error(`Expected JSON from ${availabilityUrl}, received ${contentType || 'unknown content type'}: ${text.slice(0, 120)}`);
					}

					const data = await response.json();

					status.textContent = data.status || (data.ok ? 'Passed' : 'Failed');
					status.className = data.ok ? 'text-green-300' : 'text-red-200';
					testedAt.textContent = data.testedAt || '-';
					duration.textContent = data.duration || '-';

					if (!data.ok) {
						throw new Error(data.error || 'Availability request failed.');
					}

					(data.slots || []).forEach((slot) => {
						const badge = document.createElement('span');
						badge.className = 'rounded-full border border-[#73ffff]/30 bg-[#73ffff]/10 px-3 py-1 text-[#73ffff]';
						badge.textContent = slot;
						slots.append(badge);
					});

					if (!slots.children.length) {
						const empty = document.createElement('span');
						empty.className = 'text-white/65';
						empty.textContent = 'No available slots returned.';
						slots.append(empty);
					}

					slotCount.textContent = String((data.slots || []).length);
					raw.textContent = JSON.stringify(data.raw || data, null, 2);
					slotsBox.classList.remove('hidden');
					rawBox.classList.remove('hidden');
				} catch (exception) {
					status.textContent = 'Failed';
					status.className = 'text-red-200';
					error.textContent = exception instanceof Error ? exception.message : 'Availability request failed.';
					errorBox.classList.remove('hidden');
				} finally {
					button.disabled = false;
				}
			});
		})();

		(() => {
			const form = document.querySelector('#user-login-test');
			if (!form) return;

			const status = document.querySelector('[data-user-login-status]');
			const testedAt = document.querySelector('[data-user-login-tested-at]');
			const duration = document.querySelector('[data-user-login-duration]');
			const login = document.querySelector('[data-user-login-login]');
			const password = document.querySelector('[data-user-login-password]');
			const errorBox = document.querySelector('[data-user-login-error-box]');
			const error = document.querySelector('[data-user-login-error]');
			const detailBox = document.querySelector('[data-user-login-detail-box]');
			const detail = document.querySelector('[data-user-login-detail]');
			const rawBox = document.querySelector('[data-user-login-raw-box]');
			const raw = document.querySelector('[data-user-login-raw]');
			const button = form.querySelector('button[type="submit"]');
			const pagePath = window.location.pathname;
			const userLoginUrl = pagePath.endsWith('/')
				? `${pagePath}UserLogin.php`
				: `${pagePath.replace(/\/index\.php$/i, '')}/UserLogin.php`;

			form.addEventListener('submit', async (event) => {
				event.preventDefault();

				status.textContent = 'Running';
				status.className = 'text-[#73ffff]';
				testedAt.textContent = '-';
				duration.textContent = '-';
				errorBox.classList.add('hidden');
				detailBox.classList.add('hidden');
				rawBox.classList.add('hidden');
				button.disabled = true;

				try {
					const response = await fetch(userLoginUrl, {
						method: 'POST',
						headers: { 'Content-Type': 'application/json' },
						body: JSON.stringify({
							login: login.value,
							password: password.value,
						}),
					});
					const contentType = response.headers.get('content-type') || '';

					if (!contentType.includes('application/json')) {
						const text = await response.text();
						throw new Error(`Expected JSON from ${userLoginUrl}, received ${contentType || 'unknown content type'}: ${text.slice(0, 120)}`);
					}

					const data = await response.json();

					status.textContent = data.status || (data.ok ? 'Passed' : 'Failed');
					status.className = data.ok ? 'text-green-300' : 'text-red-200';
					testedAt.textContent = data.testedAt || '-';
					duration.textContent = data.duration || '-';

					if (!data.ok) {
						throw new Error(data.error || 'User login request failed.');
					}

					detail.textContent = data.detail || 'Login accepted.';
					raw.textContent = JSON.stringify(data.raw || data, null, 2);
					detailBox.classList.remove('hidden');
					rawBox.classList.remove('hidden');
				} catch (exception) {
					status.textContent = 'Failed';
					status.className = 'text-red-200';
					error.textContent = exception instanceof Error ? exception.message : 'User login request failed.';
					errorBox.classList.remove('hidden');
				} finally {
					button.disabled = false;
				}
			});
		})();

		(() => {
			const form = document.querySelector('#user-registration-test');
			if (!form) return;

			const status = document.querySelector('[data-user-registration-status]');
			const testedAt = document.querySelector('[data-user-registration-tested-at]');
			const duration = document.querySelector('[data-user-registration-duration]');
			const name = document.querySelector('[data-user-registration-name]');
			const phone = document.querySelector('[data-user-registration-phone]');
			const email = document.querySelector('[data-user-registration-email]');
			const password = document.querySelector('[data-user-registration-password]');
			const errorBox = document.querySelector('[data-user-registration-error-box]');
			const error = document.querySelector('[data-user-registration-error]');
			const detailBox = document.querySelector('[data-user-registration-detail-box]');
			const detail = document.querySelector('[data-user-registration-detail]');
			const rawBox = document.querySelector('[data-user-registration-raw-box]');
			const raw = document.querySelector('[data-user-registration-raw]');
			const button = form.querySelector('button[type="submit"]');
			const pagePath = window.location.pathname;
			const userRegistrationUrl = pagePath.endsWith('/')
				? `${pagePath}UserRegistration.php`
				: `${pagePath.replace(/\/index\.php$/i, '')}/UserRegistration.php`;

			form.addEventListener('submit', async (event) => {
				event.preventDefault();

				status.textContent = 'Running';
				status.className = 'text-[#73ffff]';
				testedAt.textContent = '-';
				duration.textContent = '-';
				errorBox.classList.add('hidden');
				detailBox.classList.add('hidden');
				rawBox.classList.add('hidden');
				button.disabled = true;

				try {
					const response = await fetch(userRegistrationUrl, {
						method: 'POST',
						headers: { 'Content-Type': 'application/json' },
						body: JSON.stringify({
							name: name.value,
							phone: phone.value,
							email: email.value,
							password: password.value,
						}),
					});
					const contentType = response.headers.get('content-type') || '';

					if (!contentType.includes('application/json')) {
						const text = await response.text();
						throw new Error(`Expected JSON from ${userRegistrationUrl}, received ${contentType || 'unknown content type'}: ${text.slice(0, 120)}`);
					}

					const data = await response.json();

					status.textContent = data.status || (data.ok ? 'Passed' : 'Failed');
					status.className = data.ok ? 'text-green-300' : 'text-red-200';
					testedAt.textContent = data.testedAt || '-';
					duration.textContent = data.duration || '-';


					if (!data.ok) {
						const fallback = JSON.stringify(data.raw || data, null, 2);
						throw new Error(data.error || fallback || 'User registration request failed.');
					}

					detail.textContent = data.detail || 'Registration accepted.';
					raw.textContent = JSON.stringify(data.raw || data, null, 2);
					detailBox.classList.remove('hidden');
					rawBox.classList.remove('hidden');
				} catch (exception) {
					status.textContent = 'Failed';
					status.className = 'text-red-200';
					error.textContent = exception instanceof Error ? exception.message : 'User registration request failed.';
					errorBox.classList.remove('hidden');
				} finally {
					button.disabled = false;
				}
			});
		})();

		(() => {
			const form = document.querySelector('#booking-test');
			if (!form) return;

			const status = document.querySelector('[data-booking-status]');
			const testedAt = document.querySelector('[data-booking-tested-at]');
			const duration = document.querySelector('[data-booking-duration]');
			const serviceId = document.querySelector('[data-booking-service-id]');
			const performerId = document.querySelector('[data-booking-performer-id]');
			const date = document.querySelector('[data-booking-date]');
			const time = document.querySelector('[data-booking-time]');
			const count = document.querySelector('[data-booking-count]');
			const clientName = document.querySelector('[data-booking-client-name]');
			const clientEmail = document.querySelector('[data-booking-client-email]');
			const clientPhone = document.querySelector('[data-booking-client-phone]');
			const clientPassword = document.querySelector('[data-booking-client-password]');
			const errorBox = document.querySelector('[data-booking-error-box]');
			const error = document.querySelector('[data-booking-error]');
			const detailBox = document.querySelector('[data-booking-detail-box]');
			const detail = document.querySelector('[data-booking-detail]');
			const rawBox = document.querySelector('[data-booking-raw-box]');
			const raw = document.querySelector('[data-booking-raw]');
			const button = form.querySelector('button[type="submit"]');
			const pagePath = window.location.pathname;
			const bookingUrl = pagePath.endsWith('/')
				? `${pagePath}Booking.php`
				: `${pagePath.replace(/\/index\.php$/i, '')}/Booking.php`;

			form.addEventListener('submit', async (event) => {
				event.preventDefault();

				status.textContent = 'Running';
				status.className = 'text-[#73ffff]';
				testedAt.textContent = '-';
				duration.textContent = '-';
				errorBox.classList.add('hidden');
				detailBox.classList.add('hidden');
				rawBox.classList.add('hidden');
				button.disabled = true;

				try {
					const response = await fetch(bookingUrl, {
						method: 'POST',
						headers: { 'Content-Type': 'application/json' },
						body: JSON.stringify({
							serviceId: serviceId.value,
							performerId: performerId.value,
							date: date.value,
							time: time.value,
							count: count.value,
							clientName: clientName.value,
							clientEmail: clientEmail.value,
							clientPhone: clientPhone.value,
							clientPassword: clientPassword.value,
						}),
					});
					const contentType = response.headers.get('content-type') || '';

					if (!contentType.includes('application/json')) {
						const text = await response.text();
						throw new Error(`Expected JSON from ${bookingUrl}, received ${contentType || 'unknown content type'}: ${text.slice(0, 120)}`);
					}

					const data = await response.json();

					status.textContent = data.status || (data.ok ? 'Passed' : 'Failed');
					status.className = data.ok ? 'text-green-300' : 'text-red-200';
					testedAt.textContent = data.testedAt || '-';
					duration.textContent = data.duration || '-';

					if (!data.ok) {
						const fallback = JSON.stringify(data.raw || data, null, 2);
						throw new Error(data.error || fallback || 'Booking request failed.');
					}

					detail.textContent = data.detail || 'Booking accepted.';
					raw.textContent = JSON.stringify(data.raw || data, null, 2);
					detailBox.classList.remove('hidden');
					rawBox.classList.remove('hidden');
				} catch (exception) {
					status.textContent = 'Failed';
					status.className = 'text-red-200';
					error.textContent = exception instanceof Error ? exception.message : 'Booking request failed.';
					errorBox.classList.remove('hidden');
				} finally {
					button.disabled = false;
				}
			});
		})();
	</script>

	<?php include '../resources/footer.php'; ?>
</body>

</html>
