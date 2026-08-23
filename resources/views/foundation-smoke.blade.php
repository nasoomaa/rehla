@vite(['resources/css/app.css', 'resources/js/app.js'])
<main x-data="{ status: 'pending' }" x-init="status = 'ready'">
    <span data-foundation-status x-text="status">pending</span>
</main>
