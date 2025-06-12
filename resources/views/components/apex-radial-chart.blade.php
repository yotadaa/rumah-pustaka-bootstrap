@props(['data', 'id', 'data_num'])
@php
    // If no ID is passed, generate a unique one.
    $chartId = $id ?? 'chart-' . str()->random(8);
@endphp

<div class="col w-100 h-100" wire:ignore>
    <div id="{{ $chartId }}"></div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const options = {
            chart: {
                type: 'radialBar',
                height: '120%',
            },
            series: [{{ $data }}],
            {{-- labels: [{{ isset($data_num) ? $data_num : 'Progess' }}] --}}
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: '50%',
                    },
                    dataLabels: {
                        name: {
                            show: true,
                        },
                        value: {
                            show: true,
                            fontSize: '24px',
                            formatter: function(val) {
                                return val + '% \n tes';
                            }
                        }
                    }
                }
            }
        };

        const chart = new ApexCharts(document.querySelector("#{{ $chartId }}"), options);
        chart.render();
    });
</script>
