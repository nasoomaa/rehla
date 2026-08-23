{!! view_render_event('rehla.dashboard.catalog.product.edit.booking.rental.before', ['product' => $product]) !!}

<!-- Vue Component -->
<v-rental-booking></v-rental-booking>

{!! view_render_event('rehla.dashboard.catalog.product.edit.booking.rental.after', ['product' => $product]) !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-rental-booking-template"
    >
        <!-- Renting Type -->
        <x-dashboard::form.control-group class="w-full">
            <x-dashboard::form.control-group.label class="required">
                @lang('dashboard::app.catalog.products.edit.types.booking.rental.title')
            </x-dashboard::form.control-group.label>

            <x-dashboard::form.control-group.control
                type="select"
                name="booking[renting_type]"
                rules="required"
                v-model="rental_booking.renting_type"
                :label="trans('dashboard::app.catalog.products.edit.types.booking.rental.title')"
                :placeholder="trans('dashboard::app.catalog.products.edit.types.booking.rental.title')"
            >
                <option value="daily">
                    @lang('dashboard::app.catalog.products.edit.types.booking.rental.daily')
                </option>

                <option value="hourly">
                    @lang('dashboard::app.catalog.products.edit.types.booking.rental.hourly')
                </option>

                <option value="daily_hourly">
                    @lang('dashboard::app.catalog.products.edit.types.booking.rental.daily-hourly')
                </option>
            </x-dashboard::form.control-group.control>

            <x-dashboard::form.control-group.error control-name="booking[renting_type]" />
        </x-dashboard::form.control-group>

        <!-- Daily Price -->
        <x-dashboard::form.control-group
            class="w-full"
            v-if="rental_booking.renting_type == 'daily' || rental_booking.renting_type == 'daily_hourly'"
        >
            <x-dashboard::form.control-group.label class="required">
                @lang('dashboard::app.catalog.products.edit.types.booking.rental.daily-price')
            </x-dashboard::form.control-group.label>

            <x-dashboard::form.control-group.control
                type="text"
                name="booking[daily_price]"
                rules="required"
                v-model="rental_booking.daily_price"
                :label="trans('dashboard::app.catalog.products.edit.types.booking.rental.daily-price')"
                :placeholder="trans('dashboard::app.catalog.products.edit.types.booking.rental.daily-price')"
            />

            <x-dashboard::form.control-group.error control-name="booking[renting_type]" />
        </x-dashboard::form.control-group>

        <!-- Hourly Price -->
        <x-dashboard::form.control-group
            class="w-full"
            v-if="rental_booking.renting_type == 'hourly' || rental_booking.renting_type == 'daily_hourly'"
        >
            <x-dashboard::form.control-group.label class="required">
                @lang('dashboard::app.catalog.products.edit.types.booking.rental.hourly-price')
            </x-dashboard::form.control-group.label>

            <x-dashboard::form.control-group.control
                type="text"
                name="booking[hourly_price]"
                rules="required"
                v-model="rental_booking.hourly_price"
                :label="trans('dashboard::app.catalog.products.edit.types.booking.rental.hourly-price')"
                :placeholder="trans('dashboard::app.catalog.products.edit.types.booking.rental.hourly-price')"
            />

            <x-dashboard::form.control-group.error control-name="booking[hourly_price]" />
        </x-dashboard::form.control-group>

        <div v-if="rental_booking.renting_type == 'hourly' || rental_booking.renting_type == 'daily_hourly'">
            <!-- Same Slot For All -->
            <x-dashboard::form.control-group class="w-full">
                <x-dashboard::form.control-group.label class="required">
                    @lang('dashboard::app.catalog.products.edit.types.booking.rental.same-slot-for-all-days.title')
                </x-dashboard::form.control-group.label>

                <x-dashboard::form.control-group.control
                    type="select"
                    name="booking[same_slot_all_days]"
                    rules="required"
                    v-model="rental_booking.same_slot_all_days"
                    :label="trans('dashboard::app.catalog.products.edit.types.booking.rental.same-slot-for-all-days.title')"
                >
                    <option value="1">
                        @lang('dashboard::app.catalog.products.edit.types.booking.rental.same-slot-for-all-days.yes')
                    </option>

                    <option value="0">
                        @lang('dashboard::app.catalog.products.edit.types.booking.rental.same-slot-for-all-days.no')
                    </option>
                </x-dashboard::form.control-group.control>

                <x-dashboard::form.control-group.error control-name="booking[same_slot_all_days]" />
            </x-dashboard::form.control-group>
        </div>

        <!-- Slots Vue Component -->
        <v-slots
            v-if="rental_booking.renting_type == 'hourly' || rental_booking.renting_type == 'daily_hourly'"
            :booking-product="rental_booking"
            :booking-type="'rental_slot'"
            :same-slot-all-days="rental_booking.same_slot_all_days"
            :min-slot-minutes="60"
        >
        </v-slots>
    </script>

    <script type="module">
        app.component('v-rental-booking', {
            template: '#v-rental-booking-template',

            props: ['bookingProduct'],

            data() {
                return {
                    rental_booking: @json($bookingProduct && $bookingProduct?->rental_slot) ? @json($bookingProduct?->rental_slot) : {
                        renting_type: 'daily',

                        daily_price: '',

                        hourly_price: '',

                        same_slot_all_days: 1,

                        slots: [],
                    }
                }
            },
        });
    </script>
@endpushOnce