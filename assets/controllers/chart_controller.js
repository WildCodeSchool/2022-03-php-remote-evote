import { Controller } from '@hotwired/stimulus';
import '../Chart.bundle.min';
import 'chartjs-plugin-labels'

export default class extends Controller {
    static targets = ['chart'];
    connect() {
        const charts = this.chartTargets
        charts.forEach(function(chart) {
            new Chart(chart, {
                type: 'pie',
                data: {
                    labels: ['Pour', 'Contre', 'Abstention'],
                    datasets: [{
                        label: '# of Votes',
                        data: [chart.dataset.approved, chart.dataset.rejected, chart.dataset.abstention],
                        backgroundColor: [
                            'rgb(43,146,35)',
                            'rgb(186,51,51)',
                            'rgb(163,163,163)'
                        ],
                    }]
                },
                options: {
                    plugins: {
                        labels: [
                            {
                                render: 'percentage',
                                precision: 2,
                                fontSize: 16,
                                fontColor: '#fff',
                                // position: 'outside'
                            },
                        ]
                    },
                }
            });
        })
    }
}
