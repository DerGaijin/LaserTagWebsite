<!doctype html>
<html lang="en">
<head>
    <?php require '../resources/head.php'; ?>
</head>
<body>
    <?php include '../resources/header.php'; ?>

    <main class="mx-auto w-full min-w-0 max-w-[1500px] px-5 py-12 text-white">
        <section class="w-full min-w-0 overflow-hidden border border-[#00aaaa] bg-[#151515] shadow-[0_0_24px_rgba(0,170,170,0.15)]">
            <div class="flex items-center justify-between gap-4 border-b border-[#00aaaa] p-5 max-[600px]:items-start">
                <div>
                    <p class="mb-1 text-sm font-bold uppercase tracking-[0.2em] text-[#00aaaa]">SimplyBook API</p>
                    <h1 class="text-3xl font-bold">Fetch all services</h1>
                </div>
                <button id="ServicesTestButton" type="button" class="shrink-0 border border-[#00aaaa] bg-[#00aaaa] px-5 py-2 font-bold text-black transition hover:bg-transparent hover:text-[#00aaaa] disabled:cursor-wait disabled:opacity-60">Test</button>
            </div>
            <div id="ServicesResult" class="min-h-20 w-full min-w-0 overflow-hidden p-5 text-zinc-300" aria-live="polite">Press Test to fetch all services.</div>
        </section>

        <section class="mt-8 w-full min-w-0 overflow-hidden border border-[#00aaaa] bg-[#151515] shadow-[0_0_24px_rgba(0,170,170,0.15)]">
            <div class="border-b border-[#00aaaa] p-5">
                <p class="mb-1 text-sm font-bold uppercase tracking-[0.2em] text-[#00aaaa]">SimplyBook API</p>
                <h1 class="text-3xl font-bold">Check availability</h1>
            </div>
            <form id="AvailabilityTestForm" class="flex flex-wrap items-end gap-4 p-5">
                <label class="flex min-w-48 flex-1 flex-col gap-2 font-bold">Service ID
                    <input id="AvailabilityServiceId" name="service_id" type="number" min="1" value="20" required class="border border-zinc-600 bg-black px-3 py-2 font-normal text-white outline-none focus:border-[#00aaaa]">
                </label>
                <label class="flex min-w-48 flex-1 flex-col gap-2 font-bold">Date
                    <input id="AvailabilityDate" name="date" type="text" value="23.07.2026" placeholder="DD.MM.YYYY" inputmode="numeric" pattern="\d{2}\.\d{2}\.\d{4}" required class="border border-zinc-600 bg-black px-3 py-2 font-normal text-white outline-none focus:border-[#00aaaa]">
                </label>
                <label class="flex min-w-48 flex-1 flex-col gap-2 font-bold">Person count
                    <input id="AvailabilityPersonCount" name="person_count" type="number" min="1" value="1" required class="border border-zinc-600 bg-black px-3 py-2 font-normal text-white outline-none focus:border-[#00aaaa]">
                </label>
                <button id="AvailabilityTestButton" type="submit" class="shrink-0 border border-[#00aaaa] bg-[#00aaaa] px-5 py-2 font-bold text-black transition hover:bg-transparent hover:text-[#00aaaa] disabled:cursor-wait disabled:opacity-60">Test</button>
            </form>
            <div id="AvailabilityResult" class="min-h-20 w-full min-w-0 overflow-hidden px-5 pb-5 text-zinc-300" aria-live="polite">Enter a service ID and date to fetch available times.</div>
        </section>

        <section class="mt-8 w-full min-w-0 overflow-hidden border border-[#00aaaa] bg-[#151515] shadow-[0_0_24px_rgba(0,170,170,0.15)]">
            <div class="border-b border-[#00aaaa] p-5">
                <p class="mb-1 text-sm font-bold uppercase tracking-[0.2em] text-[#00aaaa]">SimplyBook API</p>
                <h1 class="text-3xl font-bold">User login</h1>
            </div>
            <form id="LoginTestForm" class="flex flex-wrap items-end gap-4 p-5">
                <label class="flex min-w-48 flex-1 flex-col gap-2 font-bold">Email
                    <input name="email" type="email" autocomplete="username" required class="border border-zinc-600 bg-black px-3 py-2 font-normal text-white outline-none focus:border-[#00aaaa]">
                </label>
                <label class="flex min-w-48 flex-1 flex-col gap-2 font-bold">Password
                    <input name="password" type="password" autocomplete="current-password" required class="border border-zinc-600 bg-black px-3 py-2 font-normal text-white outline-none focus:border-[#00aaaa]">
                </label>
                <button id="LoginTestButton" type="submit" class="shrink-0 border border-[#00aaaa] bg-[#00aaaa] px-5 py-2 font-bold text-black transition hover:bg-transparent hover:text-[#00aaaa] disabled:cursor-wait disabled:opacity-60">Test login</button>
            </form>
            <div id="LoginResult" class="min-h-20 w-full min-w-0 overflow-hidden px-5 pb-5 text-zinc-300" aria-live="polite">Enter an existing customer's email address and password to test login.</div>
        </section>

        <section class="mt-8 w-full min-w-0 overflow-hidden border border-[#00aaaa] bg-[#151515] shadow-[0_0_24px_rgba(0,170,170,0.15)]">
            <div class="border-b border-[#00aaaa] p-5">
                <p class="mb-1 text-sm font-bold uppercase tracking-[0.2em] text-[#00aaaa]">SimplyBook API</p>
                <h1 class="text-3xl font-bold">User registration</h1>
            </div>
            <form id="RegistrationTestForm" class="grid grid-cols-2 gap-4 p-5 max-[600px]:grid-cols-1">
                <label class="flex flex-col gap-2 font-bold">Name
                    <input name="name" type="text" autocomplete="name" required class="border border-zinc-600 bg-black px-3 py-2 font-normal text-white outline-none focus:border-[#00aaaa]">
                </label>
                <label class="flex flex-col gap-2 font-bold">Phone <span class="font-normal text-zinc-400">(optional)</span>
                    <input name="phone" type="tel" autocomplete="tel" class="border border-zinc-600 bg-black px-3 py-2 font-normal text-white outline-none focus:border-[#00aaaa]">
                </label>
                <label class="flex flex-col gap-2 font-bold">Email
                    <input name="email" type="email" autocomplete="username" required class="border border-zinc-600 bg-black px-3 py-2 font-normal text-white outline-none focus:border-[#00aaaa]">
                </label>
                <label class="flex flex-col gap-2 font-bold">Password
                    <input name="password" type="password" minlength="6" autocomplete="new-password" required class="border border-zinc-600 bg-black px-3 py-2 font-normal text-white outline-none focus:border-[#00aaaa]">
                </label>
                <div class="col-span-2 flex flex-wrap items-center gap-4 max-[600px]:col-span-1">
                    <button id="RegistrationTestButton" type="submit" class="shrink-0 border border-[#00aaaa] bg-[#00aaaa] px-5 py-2 font-bold text-black transition hover:bg-transparent hover:text-[#00aaaa] disabled:cursor-wait disabled:opacity-60">Register user</button>
                    <p class="text-sm text-zinc-400">This creates a real client in SimplyBook.</p>
                </div>
            </form>
            <div id="RegistrationResult" class="min-h-20 w-full min-w-0 overflow-hidden px-5 pb-5 text-zinc-300" aria-live="polite">Enter new customer details to create a SimplyBook client.</div>
        </section>

        <section class="mt-8 w-full min-w-0 overflow-hidden border border-[#00aaaa] bg-[#151515] shadow-[0_0_24px_rgba(0,170,170,0.15)]">
            <div class="flex items-center justify-between gap-4 border-b border-[#00aaaa] p-5 max-[600px]:items-start">
                <div>
                    <p class="mb-1 text-sm font-bold uppercase tracking-[0.2em] text-[#00aaaa]">SimplyBook API</p>
                    <h1 class="text-3xl font-bold">Admin login</h1>
                </div>
                <button id="AdminLoginTestButton" type="button" class="shrink-0 border border-[#00aaaa] bg-[#00aaaa] px-5 py-2 font-bold text-black transition hover:bg-transparent hover:text-[#00aaaa] disabled:cursor-wait disabled:opacity-60">Test admin login</button>
            </div>
            <div id="AdminLoginResult" class="min-h-20 w-full min-w-0 overflow-hidden p-5 text-zinc-300" aria-live="polite">Tests the admin credentials configured in .env without creating or changing anything.</div>
        </section>

        <section class="mt-8 w-full min-w-0 overflow-hidden border border-red-500 bg-[#151515] shadow-[0_0_24px_rgba(239,68,68,0.15)]">
            <div class="border-b border-red-500 p-5">
                <p class="mb-1 text-sm font-bold uppercase tracking-[0.2em] text-red-400">SimplyBook API</p>
                <h1 class="text-3xl font-bold">Book a service</h1>
            </div>
            <form id="BookingTestForm" class="grid grid-cols-2 gap-4 p-5 max-[600px]:grid-cols-1">
                <label class="flex flex-col gap-2 font-bold">Service ID
                    <input name="service_id" type="number" min="1" value="20" required class="border border-zinc-600 bg-black px-3 py-2 font-normal text-white outline-none focus:border-red-400">
                </label>
                <label class="flex flex-col gap-2 font-bold">Unit ID
                    <input name="unit_id" type="number" min="1" value="1" required class="border border-zinc-600 bg-black px-3 py-2 font-normal text-white outline-none focus:border-red-400">
                </label>
                <label class="flex flex-col gap-2 font-bold">Date
                    <input name="date" type="text" value="23.07.2026" placeholder="DD.MM.YYYY" inputmode="numeric" pattern="\d{2}\.\d{2}\.\d{4}" required class="border border-zinc-600 bg-black px-3 py-2 font-normal text-white outline-none focus:border-red-400">
                </label>
                <label class="flex flex-col gap-2 font-bold">Start time
                    <input name="time" type="time" required class="border border-zinc-600 bg-black px-3 py-2 font-normal text-white outline-none focus:border-red-400">
                </label>
                <label class="flex flex-col gap-2 font-bold">Person count
                    <input name="person_count" type="number" min="1" value="1" required class="border border-zinc-600 bg-black px-3 py-2 font-normal text-white outline-none focus:border-red-400">
                </label>
                <label class="flex flex-col gap-2 font-bold">Client ID
                    <input name="client_id" type="number" min="1" required class="border border-zinc-600 bg-black px-3 py-2 font-normal text-white outline-none focus:border-red-400">
                </label>
                <div class="col-span-2 flex flex-wrap items-center gap-4 max-[600px]:col-span-1">
                    <button id="BookingTestButton" type="submit" class="shrink-0 border border-red-500 bg-red-500 px-5 py-2 font-bold text-black transition hover:bg-transparent hover:text-red-400 disabled:cursor-wait disabled:opacity-60">Create booking</button>
                    <p class="text-sm text-red-300">This creates a real booking in SimplyBook using admin authorization.</p>
                </div>
            </form>
            <pre id="BookingResult" class="min-h-20 w-full min-w-0 overflow-x-auto whitespace-pre-wrap px-5 pb-5 text-zinc-300" aria-live="polite">Enter an available service time and existing client ID to create a booking.</pre>
        </section>
    </main>

    <script>
        const testButton = document.getElementById('ServicesTestButton');
        const result = document.getElementById('ServicesResult');
        const availabilityForm = document.getElementById('AvailabilityTestForm');
        const availabilityButton = document.getElementById('AvailabilityTestButton');
        const availabilityResult = document.getElementById('AvailabilityResult');
        const loginForm = document.getElementById('LoginTestForm');
        const loginButton = document.getElementById('LoginTestButton');
        const loginResult = document.getElementById('LoginResult');
        const registrationForm = document.getElementById('RegistrationTestForm');
        const registrationButton = document.getElementById('RegistrationTestButton');
        const registrationResult = document.getElementById('RegistrationResult');
        const adminLoginButton = document.getElementById('AdminLoginTestButton');
        const adminLoginResult = document.getElementById('AdminLoginResult');
        const bookingForm = document.getElementById('BookingTestForm');
        const bookingButton = document.getElementById('BookingTestButton');
        const bookingResult = document.getElementById('BookingResult');

        function addCell(row, value, tagName) {
            const cell = document.createElement(tagName);
            cell.className = tagName === 'th'
                ? 'max-w-[320px] break-words px-3 py-2 font-bold'
                : 'max-w-[320px] break-words px-3 py-2 align-top';
            cell.textContent = typeof value === 'object' && value !== null ? JSON.stringify(value) : String(value ?? '');
            row.appendChild(cell);
        }

        function renderServices(services, apiCallTimeMs) {
            if (!services.length) {
                result.textContent = `The API returned no services in ${apiCallTimeMs} ms.`;
                return;
            }

            const columns = [...new Set(services.flatMap(service => Object.keys(service)))];
            const count = document.createElement('p');
            count.textContent = `${services.length} services returned in ${apiCallTimeMs} ms.`;

            const tableWrap = document.createElement('div');
            tableWrap.className = 'w-full min-w-0 max-w-full overflow-x-auto border border-zinc-700';
            const table = document.createElement('table');
            table.className = 'min-w-max border-collapse text-left text-sm';
            const header = table.createTHead().insertRow();
            header.className = 'bg-[#00aaaa] text-black';
            columns.forEach(column => addCell(header, column, 'th'));

            const body = table.createTBody();
            services.forEach(service => {
                const row = body.insertRow();
                row.className = 'border-t border-zinc-700 even:bg-zinc-900';
                columns.forEach(column => addCell(row, service[column], 'td'));
            });

            tableWrap.appendChild(table);
            result.replaceChildren(count, tableWrap);
        }

        testButton.addEventListener('click', async () => {
            testButton.disabled = true;
            result.classList.remove('text-red-300');
            result.textContent = 'Fetching services...';

            try {
                const response = await fetch('services.php', { cache: 'no-store' });
                const data = await response.json();
                if (!response.ok || data.error) throw new Error(data.error || `Request failed (${response.status}).`);
                renderServices(data.services || [], data.apiCallTimeMs);
            } catch (error) {
                result.textContent = `Request failed: ${error.message}`;
                result.classList.add('text-red-300');
            } finally {
                testButton.disabled = false;
            }
        });

        availabilityForm.addEventListener('submit', async event => {
            event.preventDefault();
            availabilityButton.disabled = true;
            availabilityResult.classList.remove('text-red-300');
            availabilityResult.textContent = 'Fetching availability...';

            try {
                const params = new URLSearchParams(new FormData(availabilityForm));
                const response = await fetch(`availability.php?${params}`, { cache: 'no-store' });
                const data = await response.json();
                if (!response.ok || data.error) throw new Error(data.error || `Request failed (${response.status}).`);
                availabilityResult.textContent = data.times.length
                    ? `${data.times.length} available times returned in ${data.apiCallTimeMs} ms: ${data.times.join(', ')}`
                    : `No available times returned in ${data.apiCallTimeMs} ms.`;
            } catch (error) {
                availabilityResult.textContent = `Request failed: ${error.message}`;
                availabilityResult.classList.add('text-red-300');
            } finally {
                availabilityButton.disabled = false;
            }
        });

        loginForm.addEventListener('submit', async event => {
            event.preventDefault();
            loginButton.disabled = true;
            loginResult.classList.remove('text-red-300');
            loginResult.textContent = 'Checking login credentials...';

            try {
                const response = await fetch('login.php', {
                    method: 'POST',
                    body: new FormData(loginForm),
                    cache: 'no-store',
                });
                const data = await response.json();
                if (!response.ok || data.error) throw new Error(data.error || `Request failed (${response.status}).`);
                const { client } = data;
                loginResult.textContent = `Login succeeded in ${data.apiCallTimeMs} ms. Client: ${client.name || '(no name)'} (${client.email || '(no email)'}), ID ${client.id}${client.phone ? `, phone ${client.phone}` : ''}.`;
            } catch (error) {
                loginResult.textContent = `Login failed: ${error.message}`;
                loginResult.classList.add('text-red-300');
            } finally {
                loginButton.disabled = false;
            }
        });

        registrationForm.addEventListener('submit', async event => {
            event.preventDefault();
            registrationButton.disabled = true;
            registrationResult.classList.remove('text-red-300');
            registrationResult.textContent = 'Creating SimplyBook client...';

            try {
                const response = await fetch('register.php', {
                    method: 'POST',
                    body: new FormData(registrationForm),
                    cache: 'no-store',
                });
                const data = await response.json();
                if (!response.ok || data.error) throw new Error(data.error || `Request failed (${response.status}).`);
                const { client } = data;
                registrationResult.textContent = `Registration succeeded in ${data.apiCallTimeMs} ms. Client: ${client.name} (${client.email}), ID ${client.id}${client.phone ? `, phone ${client.phone}` : ''}.`;
                registrationForm.reset();
            } catch (error) {
                registrationResult.textContent = `Registration failed: ${error.message}`;
                registrationResult.classList.add('text-red-300');
            } finally {
                registrationButton.disabled = false;
            }
        });

        adminLoginButton.addEventListener('click', async () => {
            adminLoginButton.disabled = true;
            adminLoginResult.classList.remove('text-red-300');
            adminLoginResult.textContent = 'Checking SimplyBook admin credentials...';

            try {
                const response = await fetch('admin-login.php', { cache: 'no-store' });
                const data = await response.json();
                if (!response.ok || data.error) throw new Error(data.error || `Request failed (${response.status}).`);
                adminLoginResult.textContent = `Admin login succeeded in ${data.apiCallTimeMs} ms.`;
            } catch (error) {
                adminLoginResult.textContent = `Admin login failed: ${error.message}`;
                adminLoginResult.classList.add('text-red-300');
            } finally {
                adminLoginButton.disabled = false;
            }
        });

        bookingForm.addEventListener('submit', async event => {
            event.preventDefault();
            bookingButton.disabled = true;
            bookingResult.classList.remove('text-red-300');
            bookingResult.textContent = 'Creating SimplyBook booking...';

            try {
                const response = await fetch('book.php', {
                    method: 'POST',
                    body: new FormData(bookingForm),
                    cache: 'no-store',
                });
                const data = await response.json();
                if (!response.ok || data.error) throw new Error(data.error || `Request failed (${response.status}).`);
                bookingResult.textContent = `Booking created in ${data.apiCallTimeMs} ms:\n${JSON.stringify(data.booking, null, 2)}`;
            } catch (error) {
                bookingResult.textContent = `Booking failed: ${error.message}`;
                bookingResult.classList.add('text-red-300');
            } finally {
                bookingButton.disabled = false;
            }
        });
    </script>

    <?php include '../resources/footer.php'; ?>
</body>
</html>
