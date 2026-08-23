@php
    $bookingProduct = app('\Webkul\BookingProduct\Repositories\BookingProductRepository')->findOneByField('product_id', $product->id)
@endphp

{!! view_render_event('rehla.dashboard.catalog.product.edit.form.types.booking.before', ['product' => $product]) !!}

<!-- Vue Component -->
<v-booking-information></v-booking-information>

{!! view_render_event('rehla.dashboard.catalog.product.edit.form.types.booking.after', ['product' => $product]) !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-booking-information-template"
    >
        <div class="box-shadow relative rounded bg-white p-4 dark:bg-gray-900">
            <!-- Booking Type -->
            <x-dashboard::form.control-group class="w-full">
                <x-dashboard::form.control-group.label class="required">
                    @lang('dashboard::app.catalog.products.edit.types.booking.title')
                </x-dashboard::form.control-group.label>

                <x-dashboard::form.control-group.control
                    class="hidden"
                    name="booking[type]"
                    ::value="booking.type"
                />

                <x-dashboard::form.control-group.control
                    type="select"
                    name="booking[type]"
                    rules="required"
                    ::value="booking.type"
                    v-model="booking.type"
                    :label="trans('dashboard::app.catalog.products.edit.types.booking.title')"
                    ::disabled="! is_new"
                >
                    @foreach (['default', 'appointment', 'event', 'rental', 'table'] as $item)
                        <option value={{ $item }}>
                            @lang('dashboard::app.catalog.products.edit.types.booking.type.' . $item)
                        </option>
                    @endforeach
                </x-dashboard::form.control-group.control>

                <x-dashboard::form.control-group.error  control-name="booking[type]" />
            </x-dashboard::form.control-group>

            <!-- Location -->
            <x-dashboard::form.control-group class="w-full">
                <x-dashboard::form.control-group.label class="required">
                    @lang('dashboard::app.catalog.products.edit.types.booking.location')
                </x-dashboard::form.control-group.label>

                <x-dashboard::form.control-group.control
                    type="text"
                    rules="required"
                    name="booking[location]"
                    v-model="booking.location"
                    :label="trans('dashboard::app.catalog.products.edit.types.booking.location')"
                />

                <x-dashboard::form.control-group.error  control-name="booking[location]" />
            </x-dashboard::form.control-group>

            <!-- QTY -->
            <x-dashboard::form.control-group
                class="w-full"
                v-if="booking.type == 'default'
                    || booking.type == 'appointment'
                    || booking.type == 'rental'"
            >
                <x-dashboard::form.control-group.label class="required">
                    @lang('dashboard::app.catalog.products.edit.types.booking.qty')
                </x-dashboard::form.control-group.label>

                <x-dashboard::form.control-group.control
                    type="text"
                    name="booking[qty]"
                    rules="required|numeric|min:0"
                    v-model="booking.qty"
                    :label="trans('dashboard::app.catalog.products.edit.types.booking.qty')"
                />

                <x-dashboard::form.control-group.error  control-name="booking[qty]" />
            </x-dashboard::form.control-group>

            <!-- Available Every Week -->
            <x-dashboard::form.control-group
                class="w-full"
                v-if="booking.type != 'event' && booking.type != 'default'"
            >
                <x-dashboard::form.control-group.label class="required">
                    @lang('dashboard::app.catalog.products.edit.types.booking.available-every-week.title')
                </x-dashboard::form.control-group.label>

                <x-dashboard::form.control-group.control
                    type="select"
                    name="booking[available_every_week]"
                    rules="required"
                    v-model="booking.available_every_week"
                    :label="trans('dashboard::app.catalog.products.edit.types.booking.available-every-week.title')"
                    @change="booking.availableEveryWeekSwatch= ! booking.availableEveryWeekSwatch"
                >
                    <option value="1">
                        @lang('dashboard::app.catalog.products.edit.types.booking.available-every-week.yes')
                    </option>

                    <option value="0">
                        @lang('dashboard::app.catalog.products.edit.types.booking.available-every-week.no')
                    </option>
                </x-dashboard::form.control-group.control>

                <x-dashboard::form.control-group.error  control-name="booking[available_every_week]" />
            </x-dashboard::form.control-group>

            <div
                class="flex gap-2.5"
                v-if="! parseInt(booking.available_every_week)"
            >
                <!-- Available From  -->
                <x-dashboard::form.control-group class="w-full">
                    <x-dashboard::form.control-group.label class="required">
                        @lang('dashboard::app.catalog.products.edit.types.booking.available-from')
                    </x-dashboard::form.control-group.label>

                    @php
                        $dateMin = \Carbon\Carbon::yesterday()->format('Y-m-d 23:59:59');
                    @endphp

                    <template v-if="booking.type == 'event'">
                        <x-dashboard::form.control-group.control
                            type="datetime"
                            name="booking[available_from]"
                            :rules="'required|after:' . $dateMin"
                            v-model="booking.available_from"
                            :label="trans('dashboard::app.catalog.products.edit.types.booking.available-from')"
                            :placeholder="trans('dashboard::app.catalog.products.edit.types.booking.available-from')"
                        />
                    </template>

                    <template v-else>
                        <x-dashboard::form.control-group.control
                            type="date"
                            name="booking[available_from]"
                            :rules="'required|after:' . $dateMin"
                            v-model="booking.available_from"
                            :label="trans('dashboard::app.catalog.products.edit.types.booking.available-from')"
                            :placeholder="trans('dashboard::app.catalog.products.edit.types.booking.available-from')"
                        />
                    </template>

                    <x-dashboard::form.control-group.error  control-name="booking[available_from]" />
                </x-dashboard::form.control-group>

                <!-- Available To -->
                <x-dashboard::form.control-group class="w-full">
                    <x-dashboard::form.control-group.label class="required">
                        @lang('dashboard::app.catalog.products.edit.types.booking.available-to')
                    </x-dashboard::form.control-group.label>

                    <template v-if="booking.type == 'event'">
                        <x-dashboard::form.control-group.control
                            type="datetime"
                            name="booking[available_to]"
                            ::rules="'required|after:' + booking.available_from"
                            v-model="booking.available_to"
                            :label="trans('dashboard::app.catalog.products.edit.types.booking.available-to')"
                            :placeholder="trans('dashboard::app.catalog.products.edit.types.booking.available-to')"
                        />
                    </template>

                    <template v-else>
                        <x-dashboard::form.control-group.control
                            type="date"
                            name="booking[available_to]"
                            ::rules="'required|after_or_equal:' + booking.available_from"
                            v-model="booking.available_to"
                            :label="trans('dashboard::app.catalog.products.edit.types.booking.available-to')"
                            :placeholder="trans('dashboard::app.catalog.products.edit.types.booking.available-to')"
                        />
                    </template>

                    <x-dashboard::form.control-group.error  control-name="booking[available_to]" />
                </x-dashboard::form.control-group>
            </div>

            <!-- Allow Cancellation -->
            <x-dashboard::form.control-group class="w-full">
                <x-dashboard::form.control-group.label>
                    @lang('dashboard::app.catalog.products.edit.types.booking.allow-cancellation.title')
                </x-dashboard::form.control-group.label>

                <x-dashboard::form.control-group.control
                    type="select"
                    name="booking[allow_cancellation]"
                    v-model="booking.allow_cancellation"
                    :label="trans('dashboard::app.catalog.products.edit.types.booking.allow-cancellation.title')"
                >
                    <option value="1">
                        @lang('dashboard::app.catalog.products.edit.types.booking.allow-cancellation.yes')
                    </option>

                    <option value="0">
                        @lang('dashboard::app.catalog.products.edit.types.booking.allow-cancellation.no')
                    </option>
                </x-dashboard::form.control-group.control>
            </x-dashboard::form.control-group>

            @php
                $bookingTypes = [
                    'default',
                    'appointment',
                    'event',
                    'rental',
                    'table'
                ];
            @endphp

            @foreach ($bookingTypes as $type)
                <template v-if="booking.type === '{{ $type }}'">
                    @include('dashboard::catalog.products.edit.types.booking.' . $type, ['bookingProduct' => $bookingProduct])
                </template>
            @endforeach
        </div>
    </script>

    <script type="module">
        defineRule('required_if', (value, { condition = true } = {}) => {
            if (condition) {
                if (
                    value === null
                    || value === undefined
                    || value === ''
                ) {
                    return false;
                }
            }

            return true;
        });

        defineRule('after', (value, [target]) => {
            if (! value || ! target) {
                return false;
            }

            return new Date(value) > new Date(target);
        });

        defineRule('after_or_equal', (value, [target]) => {
            if (! value || ! target) {
                return true;
            }

            return new Date(value) >= new Date(target);
        });

        app.component('v-booking-information', {
            template: '#v-booking-information-template',

            data() {
                return {
                    is_new: @json($bookingProduct) ? false : true,

                    booking: @json($bookingProduct) ? @json($bookingProduct) : {

                        type: 'default',

                        location: '',

                        qty: 0,

                        available_every_week: 0,

                        availableEveryWeekSwatch: true,

                        available_from: '',

                        available_to: '',

                        allow_cancellation: 1
                    }
                }
            },

            created() {
                const fromRaw = "{{ $bookingProduct && $bookingProduct->available_from ? $bookingProduct->available_from->format('Y-m-d H:i:s') : '' }}";
                const toRaw = "{{ $bookingProduct && $bookingProduct->available_to ? $bookingProduct->available_to->format('Y-m-d H:i:s') : '' }}";

                if (this.booking.type === 'event') {
                    this.booking.available_from = fromRaw;
                    this.booking.available_to = toRaw;
                } else {
                    this.booking.available_from = fromRaw ? fromRaw.substring(0, 10) : '';
                    this.booking.available_to = toRaw ? toRaw.substring(0, 10) : '';
                }
            },

            watch: {
                'booking.type'(newType, oldType) {
                    if (oldType === 'event' && newType !== 'event') {
                        if (this.booking.available_from) {
                            this.booking.available_from = String(this.booking.available_from).substring(0, 10);
                        }

                        if (this.booking.available_to) {
                            this.booking.available_to = String(this.booking.available_to).substring(0, 10);
                        }
                    }
                },
            }
        });
    </script>

    <!-- Slots component Included -->
    @include('dashboard::catalog.products.edit.types.booking.slots')

    <!-- Empty Info Page Included -->
    @include('dashboard::catalog.products.edit.types.booking.empty-info')
@endpushOnce
