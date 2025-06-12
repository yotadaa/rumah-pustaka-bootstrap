@props(['series', 'categories', 'id'])

@php
    $chartId = $id ?? 'chart-' . str()->random(8);
@endphp

<div class="col" wire:ignore>
    <div id="{{ $chartId }}"></div>
</div>

@push('scripts')
    <script>
        (function() {
            const chartElementId = '#{{ $chartId }}';

            const options = {
                chart: {
                    type: 'line',
                    height: 100, // make it flat and thin
                    sparkline: {
                        enabled: true
                    }, // remove axes/labels for a clean line
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                series: [{
                    name: 'Progress',
                    data: {!! json_encode($series) !!}
                }],
                colors: ['#0d6efd'],
                tooltip: {
                    enabled: true,
                    x: {
                        show: false
                    },
                    y: {
                        formatter: val => val + '%'
                    }
                }
            };

            const chart = new ApexCharts(document.querySelector(chartElementId), options);
            chart.render();

            // Livewire update listener
            window.addEventListener('update-chart-{{ $chartId }}', event => {
                const newData = event.detail[0].data;
                chart.updateSeries([{
                    data: newData
                }]);
            });
        })();
    </script>
@endpush
