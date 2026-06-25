<!DOCTYPE html>
<html lang="de">
    <head>
        <?php require '../resources/head.php'; ?>
        <script src="https://cdn.jsdelivr.net/npm/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>
    </head>
    <body>
        <?php include '../resources/header.php'; ?>

        <main class="flex flex-col items-center gap-8 px-[100px] py-[25px] max-[1260px]:px-[15px] max-[775px]:px-[5px]">
            <section class="w-full max-w-[1000px] rounded-[25px] bg-[var(--ContentBoxBackground)] px-8 py-7 text-center shadow-[10px_10px_20px_black] max-[775px]:px-4">
                <p class="text-sm uppercase tracking-[0.24em] text-[#73ffff]">Muttizettel</p>
                <h1 class="mt-2 text-center text-[34px] leading-tight max-[775px]:text-[28px]">Eintragen, PDF herunterladen, unterschreiben</h1>
                <p class="mt-4 font-[Arial,Helvetica,sans-serif] text-lg leading-7 text-white/90 max-[775px]:text-base">
                    Trage die Begleitperson, den Spieltermin und bis zu sechs Kinder ein. Der vorhandene Muttizettel wird direkt im Browser ausgefüllt und heruntergeladen.
                </p>
                <div class="mt-5 rounded-[15px] border border-[#00aaaa] bg-[#151515] p-4 font-[Arial,Helvetica,sans-serif] text-lg leading-7 text-white/90 max-[775px]:text-base">
                    <b>Wichtig:</b> Minderjährige benötigen einen vollständig ausgefüllten und unterschriebenen Muttizettel sowie die darauf eingetragene Begleitperson vor Ort. Ohne Muttizettel oder ohne eingetragene Begleitperson ist keine Teilnahme erlaubt.
                </div>
            </section>

            <form id="MuttizettelForm" class="w-full max-w-[1000px] rounded-[25px] bg-[#2a2a2a] p-6 shadow-[10px_10px_20px_black] max-[775px]:p-4">
                <div class="grid grid-cols-2 gap-4 max-[850px]:grid-cols-1">
                    <label class="flex flex-col gap-2 font-[Arial,Helvetica,sans-serif] text-white/90">
                        Name Begleitperson
                        <input name="companion_name" type="text" class="rounded-[10px] border border-white/10 bg-[#151515] p-3 text-white outline-none focus:border-[#73ffff]" />
                    </label>
                    <label class="flex flex-col gap-2 font-[Arial,Helvetica,sans-serif] text-white/90">
                        Telefonnummer
                        <input name="phone" type="tel" class="rounded-[10px] border border-white/10 bg-[#151515] p-3 text-white outline-none focus:border-[#73ffff]" />
                    </label>
                    <label class="flex flex-col gap-2 font-[Arial,Helvetica,sans-serif] text-white/90">
                        Adresse Begleitperson
                        <input name="companion_address" type="text" class="rounded-[10px] border border-white/10 bg-[#151515] p-3 text-white outline-none focus:border-[#73ffff]" />
                    </label>
                    <label class="flex flex-col gap-2 font-[Arial,Helvetica,sans-serif] text-white/90">
                        Termin des Spiels
                        <input name="event_date" type="date" class="rounded-[10px] border border-white/10 bg-[#151515] p-3 text-white outline-none focus:border-[#73ffff]" />
                    </label>
                </div>

                <div class="mt-8">
                    <div>
                        <p class="text-sm uppercase tracking-[0.24em] text-[#73ffff]">Spieler</p>
                        <h2 class="text-[28px] leading-tight max-[775px]:text-[24px]">Kinder eintragen</h2>
                    </div>
                </div>

                <div id="ChildrenGrid" class="mt-4 grid grid-cols-1 gap-4">
                    <?php for ($i = 1; $i <= 6; $i++): ?>
                        <div class="child-row rounded-[15px] border border-white/10 bg-[#151515] p-3">
                            <div class="flex items-start gap-2">
                                <div class="grid flex-1 grid-cols-[1.2fr_180px_1.4fr] gap-3 max-[850px]:grid-cols-1">
                                    <label class="child-name-label flex flex-col gap-2 font-[Arial,Helvetica,sans-serif] text-white/90">
                                        Name Kind <?= $i ?>
                                        <input name="children[]" type="text" class="rounded-[10px] border border-white/10 bg-[#202020] p-3 text-white outline-none focus:border-[#73ffff]" />
                                    </label>
                                    <label class="child-birthday-label flex flex-col gap-2 font-[Arial,Helvetica,sans-serif] text-white/90">
                                        Geburtsdatum
                                        <input name="birthdays[]" type="date" class="rounded-[10px] border border-white/10 bg-[#202020] p-3 text-white outline-none focus:border-[#73ffff]" />
                                    </label>
                                    <label class="child-address-label flex flex-col gap-2 font-[Arial,Helvetica,sans-serif] text-white/90">
                                        Adresse
                                        <input name="child_addresses[]" type="text" class="rounded-[10px] border border-white/10 bg-[#202020] p-3 text-white outline-none focus:border-[#73ffff]" />
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>

                <label class="mt-4 flex max-w-[360px] flex-col gap-2 font-[Arial,Helvetica,sans-serif] text-white/90">
                    Ort und Datum
                    <input id="PlaceDate" name="place_date" type="text" class="rounded-[10px] border border-white/10 bg-[#151515] p-3 text-white outline-none focus:border-[#73ffff]" />
                </label>

                <div class="mt-8 rounded-[15px] border border-[#00aaaa] bg-[#151515] p-4 font-[Arial,Helvetica,sans-serif] text-white/90">
                    Die sechs Kinder werden direkt in die Vorlage eingetragen. Nicht benötigte Felder können einfach leer bleiben.
                </div>

                <p id="DownloadError" hidden class="mt-4 rounded-[12px] border border-red-400 bg-red-950/40 p-3 font-[Arial,Helvetica,sans-serif] text-red-100"></p>
                <button id="DownloadPdf" type="submit" class="Button_Book mt-6">Muttizettel als PDF herunterladen</button>
            </form>
        </main>

        <script>
            const form = document.querySelector('#MuttizettelForm');
            const childrenGrid = document.querySelector('#ChildrenGrid');
            const downloadButton = document.querySelector('#DownloadPdf');
            const errorBox = document.querySelector('#DownloadError');
            const placeDateInput = document.querySelector('#PlaceDate');
            const templatePdfUrl = '../resources/Muttizettel.pdf';

            function formatDate(value) {
                if (!value) return '';

                const [year, month, day] = value.split('-');
                return `${day}.${month}.${year}`;
            }

            function getTodayText() {
                const today = new Date();
                const day = String(today.getDate()).padStart(2, '0');
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const year = today.getFullYear();

                return `Verden, ${day}.${month}.${year}`;
            }

            function collectChildren() {
                return Array.from(childrenGrid.querySelectorAll('.child-row')).map((row) => ({
                    name: row.querySelector('input[name="children[]"]').value.trim(),
                    birthday: formatDate(row.querySelector('input[name="birthdays[]"]').value),
                    address: row.querySelector('input[name="child_addresses[]"]').value.trim(),
                })).filter((child) => child.name || child.birthday || child.address);
            }

            function drawText(page, font, text, x, y, size = 10) {
                if (!text) return;

                page.drawText(text, {
                    x,
                    y,
                    size,
                    font,
                    color: PDFLib.rgb(0, 0, 0),
                    maxWidth: 170,
                });
            }

            function fillTextField(field, value) {
                if (!field || !value || typeof field.setText !== 'function') return false;

                field.setText(value);
                return true;
            }

            function findField(fields, fieldName) {
                return fields.find((field) => field.getName() === fieldName) || null;
            }

            function fillFormField(fields, fieldName, value) {
                const field = findField(fields, fieldName);
                if (!fillTextField(field, value)) return false;

                return true;
            }

            function fillPdfFormFields(pdfDoc, font, data, children) {
                const pdfForm = pdfDoc.getForm();
                const fields = pdfForm.getFields().filter((field) => typeof field.setText === 'function');
                if (fields.length === 0) return false;

                const companionName = data.get('companion_name')?.trim();
                const phone = data.get('phone')?.trim();
                const companionAddress = data.get('companion_address')?.trim();
                const eventDate = formatDate(data.get('event_date'));
                const placeDate = data.get('place_date')?.trim();
                let filledFields = 0;

                filledFields += fillFormField(fields, 'E_Name', companionName) ? 1 : 0;
                filledFields += fillFormField(fields, 'E_Telefon', phone) ? 1 : 0;
                filledFields += fillFormField(fields, 'E_Address', companionAddress) ? 1 : 0;
                filledFields += fillFormField(fields, 'Appointment', eventDate) ? 1 : 0;
                filledFields += fillFormField(fields, 'Date', placeDate) ? 1 : 0;

                children.slice(0, 6).forEach((child, index) => {
                    const childNumber = index + 1;
                    filledFields += fillFormField(fields, `K${childNumber}_Name`, child.name) ? 1 : 0;
                    filledFields += fillFormField(fields, `K${childNumber}_Birthday`, child.birthday) ? 1 : 0;
                    filledFields += fillFormField(fields, `K${childNumber}_Address`, child.address) ? 1 : 0;
                });

                if (filledFields === 0) {
                    const valuesByVisualOrder = [
                        companionName,
                        phone,
                        companionAddress,
                        eventDate,
                        placeDate,
                        ...children.slice(0, 6).map((child) => child.name),
                        ...children.slice(0, 6).map((child) => child.birthday),
                        ...children.slice(0, 6).map((child) => child.address),
                    ].filter(Boolean);

                    fields.forEach((field, index) => {
                        fillTextField(field, valuesByVisualOrder[index]);
                    });
                }

                pdfForm.updateFieldAppearances(font);
                return true;
            }

            function drawPdfOverlay(pdfDoc, font, data, children) {
                const page = pdfDoc.getPages()[0];

                drawText(page, font, data.get('companion_name')?.trim(), 128, 279, 10);
                drawText(page, font, data.get('phone')?.trim(), 148, 260, 10);
                drawText(page, font, data.get('companion_address')?.trim(), 128, 241, 10);
                drawText(page, font, formatDate(data.get('event_date')), 155, 222, 10);
                drawText(page, font, data.get('place_date')?.trim(), 10, 12, 8);

                const childPositions = [
                    { x: 12, y: 137, birthdayY: 118, addressY: 99 },
                    { x: 137, y: 137, birthdayY: 118, addressY: 99 },
                    { x: 261, y: 137, birthdayY: 118, addressY: 99 },
                    { x: 384, y: 137, birthdayY: 118, addressY: 99 },
                    { x: 12, y: 80, birthdayY: 61, addressY: 42 },
                    { x: 137, y: 80, birthdayY: 61, addressY: 42 },
                ];

                children.slice(0, 6).forEach((child, index) => {
                    const position = childPositions[index];
                    drawText(page, font, child.name, position.x, position.y, 9);
                    drawText(page, font, child.birthday, position.x, position.birthdayY, 9);
                    drawText(page, font, child.address, position.x, position.addressY, 9);
                });
            }

            async function createFilledPdf(event) {
                event.preventDefault();
                errorBox.hidden = true;
                downloadButton.disabled = true;
                downloadButton.textContent = 'PDF wird erstellt...';

                try {
                    const pdfBytes = await fetch(templatePdfUrl).then((response) => {
                        if (!response.ok) throw new Error('PDF-Vorlage konnte nicht geladen werden.');
                        return response.arrayBuffer();
                    });
                    const pdfDoc = await PDFLib.PDFDocument.load(pdfBytes);
                    const font = await pdfDoc.embedFont(PDFLib.StandardFonts.Helvetica);
                    const data = new FormData(form);
                    const children = collectChildren();

                    if (!fillPdfFormFields(pdfDoc, font, data, children)) {
                        drawPdfOverlay(pdfDoc, font, data, children);
                    }

                    const filledPdfBytes = await pdfDoc.save();
                    const blob = new Blob([filledPdfBytes], { type: 'application/pdf' });
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = 'muttizettel-lasertag-verden.pdf';
                    link.click();
                    URL.revokeObjectURL(link.href);
                } catch (error) {
                    errorBox.textContent = error.message || 'Der PDF-Download konnte nicht erstellt werden.';
                    errorBox.hidden = false;
                } finally {
                    downloadButton.disabled = false;
                    downloadButton.textContent = 'Muttizettel als PDF herunterladen';
                }
            }

            form.addEventListener('submit', createFilledPdf);
            placeDateInput.value = getTodayText();
        </script>

        <?php $currentFooter = 'muttizettel'; include '../resources/footer.php'; ?>
    </body>
</html>
