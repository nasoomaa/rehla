<!-- Accordion Component -->
<x-dashboard::accordion title="Test Accordion">
    <x-slot:header>
        Accordion Header
    </x-slot>

    <x-slot:content>
        Accordion Content
    </x-slot>
</x-dashboard::accordion>

<!--
    Chart | Bar Chart Component

    Note: To use charts, you need to require the Chart.js library.
-->
<x-dashboard::charts.bar
    ::labels="chartLabels"
    ::datasets="chartDatasets"
/>

<!--
    Chart | Line Chart Component

    Note: To use charts, you need to require the Chart.js library.
-->
<x-dashboard::charts.line
    ::labels="chartLabels"
    ::datasets="chartDatasets"
/>

<!-- Datagrid Component -->
<x-dashboard::datagrid
    :src="route('admin.sales.orders.index')"
/>

<!-- Datagrid | Export Component-->
<x-dashboard::datagrid.export
    :src="route('admin.sales.orders.index')"
/>

<!-- Drawer Component -->
<x-dashboard::drawer>
    <x-slot:toggle>
        Drawer Toggle
    </x-slot>

    <x-slot:header>
        Drawer Header
    </x-slot>

    <x-slot:content>
        Drawer Content
    </x-slot>
</x-dashboard::drawer>

<!-- Dropdown Component-->
<x-dashboard::dropdown>
    <x-slot:toggle>
        Toogle
    </x-slot>

    <x-slot:content>
        Content
    </x-slot>
</x-dashboard::dropdown>

<!-- Flash Group Component-->
<x-dashboard::flash-group />

<!-- Flat Picker | Date Component -->
<x-dashboard::flat-picker.date ::allow-input="false">
    <input
        value=""
        class="flex min-h-[39px] w-full rounded-md border px-3 py-2 text-sm text-gray-600 transition-all hover:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400"
        type="date"
        name="created_at"
        placeholder="Created At"
        @change=""
    />
</x-dashboard::flat-picker.date>

<!-- Flat Picker | Datetime Component -->
<x-dashboard::flat-picker.datetime ::allow-input="false">
    <input
        value=""
        class="flex min-h-[39px] w-full rounded-md border px-3 py-2 text-sm text-gray-600 transition-all hover:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400"
        type="datetime-local"
        name="created_at"
        placeholder="Created At"
        @change=""
    />
</x-dashboard::flat-picker.datetime>

<!-- Form Control Group | Text Type Component -->
<x-dashboard::form.control-group>
    <x-dashboard::form.control-group.label class="required">
        Name
    </x-dashboard::form.control-group.label>

    <x-dashboard::form.control-group.control
        type="text"
        name="name"
        rules="required"
        :value=""
        label="Name"
        placeholder="Name"
    />

    <x-dashboard::form.control-group.error control-name="name" />
</x-dashboard::form.control-group>

<!-- Form Control Group | Price Type Component -->
<x-dashboard::form.control-group>
    <x-dashboard::form.control-group.label class="required">
        Price
    </x-dashboard::form.control-group.label>

    <x-dashboard::form.control-group.control
        type="price"
        name="price"
        value="2.00"
        rules="required"
        label="Price"
        placeholder="Price"
    />

    <x-dashboard::form.control-group.error control-name="price" />
</x-dashboard::form.control-group>

<!-- Form Control Group | File Type Component -->
<x-dashboard::form.control-group>
    <x-dashboard::form.control-group.label class="required">
        File Upload
    </x-dashboard::form.control-group.label>

    <x-dashboard::form.control-group.control
        type="file"
        id="file"
        name="file"
    />

    <x-dashboard::form.control-group.error control-name="file" />
</x-dashboard::form.control-group>

<!-- Form Control Group | Color Type Component -->
<x-dashboard::form.control-group>
    <x-dashboard::form.control-group.label>
        Color
    </x-dashboard::form.control-group.label>

    <x-dashboard::form.control-group.control
        type="color"
        name="color"
        placeholder="Color"
    />

    <x-dashboard::form.control-group.error control-name="color" />
</x-dashboard::form.control-group>

<!-- Form Control Group | Textarea Type Component -->
<x-dashboard::form.control-group>
    <x-dashboard::form.control-group.label>
        Description
    </x-dashboard::form.control-group.label>

    <x-dashboard::form.control-group.control
        type="textarea"
        name="description"
        value=""
        label="Description"
    />

    <x-dashboard::form.control-group.error control-name="description" />
</x-dashboard::form.control-group>

<!-- Form Control Group | Date Type Component -->
<x-dashboard::form.control-group>
    <x-dashboard::form.control-group.label>
        Date Of Birth
    </x-dashboard::form.control-group.label>

    <x-dashboard::form.control-group.control
        type="date"
        name="date_of_birth"
        label="Date Of Birth"
        placeholder="Date Of Birth"
    />

    <x-dashboard::form.control-group.error control-name="date_of_birth" />
</x-dashboard::form.control-group>

<!-- Form Control Group | Datetime Type Component -->
<x-dashboard::form.control-group>
    <x-dashboard::form.control-group.label>
        Date Of Birth
    </x-dashboard::form.control-group.label>

    <x-dashboard::form.control-group.control
        type="datetime"
        name="date_of_birth"
        label="Date Of Birth"
        placeholder="Date Of Birth"
    />

    <x-dashboard::form.control-group.error control-name="date_of_birth" />
</x-dashboard::form.control-group>

<!-- Form Control Group | Time Type Component -->
<x-dashboard::form.control-group>
    <x-dashboard::form.control-group.label class="required">
        Time
    </x-dashboard::form.control-group.label>

    <x-dashboard::form.control-group.control
        type="time"
        name="time"
        placeholder="Time"
        rules="required"
        label="Time"
    />

    <x-dashboard::form.control-group.error control-name="time" />
</x-dashboard::form.control-group>

<!-- Form Control Group | Select Type Component -->
<x-dashboard::form.control-group>
    <x-dashboard::form.control-group.label>
        Customer Group
    </x-dashboard::form.control-group.label>

    <x-dashboard::form.control-group.control
        type="select"
        name="group"
        rules="required"
        label="Customer Group"
    >
        <!-- Default Option -->
        <option value="0">
            Guest
        </option>

        <option value="1">
            Customer
        </option>

        <option value="2">
            Wholesaler
        </option>
    </x-dashboard::form.control-group.control>

    <x-dashboard::form.control-group.error control-name="group" />
</x-dashboard::form.control-group>

<!-- Form Control Group | Multiselect Type Component -->
<x-dashboard::form.control-group>
    <x-dashboard::form.control-group.label>
        Customer Groups
    </x-dashboard::form.control-group.label>

    <x-dashboard::form.control-group.control
        type="multiselect"
        name="groups"
        rules="required"
        label="Customer Group"
    >
        <!-- Default Option -->
        <option value="0">
            Guest
        </option>

        <option value="1">
            Customer
        </option>

        <option value="2">
            Wholesaler
        </option>
    </x-dashboard::form.control-group.control>

    <x-dashboard::form.control-group.error control-name="groups" />
</x-dashboard::form.control-group>

<!-- Form Control Group | Checkbox Type Component -->
<x-dashboard::form.control-group>
    <x-dashboard::form.control-group.control
        type="checkbox"
        id="is_unique"
        name="is_unique"
        value="1"
        for="is_unique"
    />

    <x-dashboard::form.control-group.label
        for="is_unique"
    >
        Is Unique
    </x-dashboard::form.control-group.label>
</x-dashboard::form.control-group>

<!-- Form Control Group | Radio Type Component -->
<x-dashboard::form.control-group>
    <x-dashboard::form.control-group.control
        type="radio"
        id="is_unique"
        name="is_unique"
        value="1"
        for="is_unique"
    />

    <x-dashboard::form.control-group.label
        for="is_unique"
    >
        Is Unique
    </x-dashboard::form.control-group.label>
</x-dashboard::form.control-group>

<!-- Form Control Group | Switch Type Component -->
<x-dashboard::form.control-group>
    <x-dashboard::form.control-group.label>
        Status
    </x-dashboard::form.control-group.label>

    <x-dashboard::form.control-group.control
        type="switch"
        class="cursor-pointer"
        name="status"
        value="1"
        label="Status"
    />

    <x-dashboard::form.control-group.error control-name="status" />
</x-dashboard::form.control-group>

<!-- Form Control Group | Image Type Component -->
<x-dashboard::form.control-group>
    <x-dashboard::form.control-group.label>
        Slider Image
    </x-dashboard::form.control-group.label>

    <x-dashboard::form.control-group.control
        type="image"
        name="slider_image"
        rules="required"
        :is-multiple="false"
    />

    <x-dashboard::form.control-group.error control-name="slider_image" />
</x-dashboard::form.control-group>

<!-- Form | Basic/Traditional Component  -->
<x-dashboard::form action="">
    <x-dashboard::form.control-group>
        <x-dashboard::form.control-group.label>
            Email
        </x-dashboard::form.control-group.label>

        <x-dashboard::form.control-group.control
            type="email"
            name="email"
            rules="required|email"
            value=""
            label="Email"
            placeholder="email@example.com"
        />

        <x-dashboard::form.control-group.error control-name="email" />
    </x-dashboard::form.control-group>
</x-dashboard::form>

<!-- Form | Customized/Ajax Component -->
<x-dashboard::form
    v-slot="{ meta, errors, handleSubmit }"
    as="div"
>
    <form @submit="handleSubmit($event, callMethodInComponent)">
        <x-dashboard::form.control-group>
            <x-dashboard::form.control-group.label>
                Email
            </x-dashboard::form.control-group.label>

            <x-dashboard::form.control-group.control
                type="email"
                name="email"
                rules="required"
                :value="old('email')"
                label="Email"
                placeholder="email@example.com"
            />

            <x-dashboard::form.control-group.error control-name="email" />
        </x-dashboard::form.control-group>

        <button>Submit</button>
    </form>
</x-dashboard::form>

<!-- Media | Image Component -->
<x-dashboard::media.images
    name="images[files]"
    allow-multiple="true"
    show-placeholders="true"
    :uploaded-images="$product->images"
/>

<!-- Media | Video Component -->
<x-dashboard::media.videos
    name="videos[files]"
    :allow-multiple="true"
    :uploaded-videos="$product->videos"
/>

<!-- Modal Component -->
<x-dashboard::modal>
    <x-slot:toggle>
        Modal Toggle
    </x-slot>

    <x-slot:header>
        Modal Header
    </x-slot>

    <x-slot:content>
        Modal Content
    </x-slot>
</x-dashboard::modal>

<!-- SEO Componnet -->
<x-dashboard::seo />

<!-- Star Rating Component -->
<x-dashboard::star-rating
    :is-editable="false"
    :value="$review->rating"
/>

<!-- Table Component -->
<x-dashboard::table>
    <x-dashboard::table.thead>
        <x-dashboard::table.thead.tr>
            <x-dashboard::table.th>
                Heading 1
            </x-dashboard::table.th>

            <x-dashboard::table.th>
                Heading 2
            </x-dashboard::table.th>

            <x-dashboard::table.th>
                Heading 3
            </x-dashboard::table.th>

            <x-dashboard::table.th>
                Heading 4
            </x-dashboard::table.th>
        </x-dashboard::table.thead.tr>
    </x-dashboard::table.thead>

    <x-dashboard::table.tbody>
        <x-dashboard::table.tbody.tr>
            <x-dashboard::table.td>
                Column 1
            </x-dashboard::table.td>

            <x-dashboard::table.td>
                Column 2
            </x-dashboard::table.td>

            <x-dashboard::table.td>
                Column 3
            </x-dashboard::table.td>

            <x-dashboard::table.td>
                Column 4
            </x-dashboard::table.td>
        </x-dashboard::table.thead.tr>
    </x-dashboard::table.tbody>
</x-dashboard::table>

<!-- Tabs Component -->
<x-dashboard::tabs>
    <x-dashboard::tabs.item title="Tab 1">
        Tab 1 Content
    </x-dashboard::tabs.item>

    <x-dashboard::tabs.item title="Tab 2">
        Tab 2 Content
    </x-dashboard::tabs.item>
</x-dashboard::tabs>

<!-- Tinymce Component -->
<x-dashboard::form.control-group>
    <x-dashboard::form.control-group.label>
        Content
    </x-dashboard::form.control-group.label>

    <x-dashboard::form.control-group.control
        type="textarea"
        id="content"
        name="html_content"
        rules="required"
        :value="old('html_content')"
        label="Content"
        placeholder="Content"
        :tinymce="true"
    />

    <x-dashboard::form.control-group.error control-name="html_content" />
</x-dashboard::form.control-group>

<!-- Tree | Checkbox Individual Component -->
<x-dashboard::tree.view
    input-type="checkbox"
    selection-type="hierarchical"
    name-field="parent_id"
    value-field="key"
    id-field="key"
    :items="json_encode($availableItems)"
    :value="json_encode($savedValues)"
    :fallback-locale="config('app.fallback_locale')"
/>

<!-- Tree | Checkbox Hierarchical Component -->
<x-dashboard::tree.view
    input-type="checkbox"
    selection-type="hierarchical"
    name-field="parent_id"
    value-field="key"
    id-field="key"
    :items="json_encode($availableItems)"
    :value="json_encode($savedValues)"
    :fallback-locale="config('app.fallback_locale')"
/>

<!-- Tree | Radio Component -->
<x-dashboard::tree.view
    input-type="radio"
    name-field="parent_id"
    value-field="id"
    id-field="id"
    :items="json_encode($availableItems)"
    :value="$savedValue"
    :fallback-locale="config('app.fallback_locale')"
/>

<!-- Status  Label -->
<div class="label-canceled">Canceled</div>

<div class="label-info">Information</div>

<div class="label-completed">Completed</div>

<div class="label-closed">Closed</div>

<div class="label-processing">Processing</div>

<div class="label-pending">Pending</div>
