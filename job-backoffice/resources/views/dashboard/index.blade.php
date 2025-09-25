<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('dashboard.dashboard_analytics') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Admin Dashboard --}}
            @if(isset($analytics['activeUsers']))
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

                    <x-dashboard-card :title="__('dashboard.active_users')" :value="$analytics['activeUsers']"
                        :subtitle="__('dashboard.last_30_days')" />

                    <x-dashboard-card :title="__('dashboard.active_job_postings')" :value="$analytics['activeJobs']"
                        :subtitle="__('dashboard.currently_active')" />

                    <x-dashboard-card :title="__('dashboard.total_applications')" :value="$analytics['totalApplications']"
                        :subtitle="__('dashboard.all_time')" />

                </div>

                <x-dashboard-table :title="__('dashboard.most_applied_jobs')" :headers="[__('dashboard.job_title'), __('dashboard.company'), __('dashboard.applications')]">
                    @foreach($analytics['mostAppliedJobs'] as $job)
                        <tr>
                            <td class="px-6 py-4 text-sm">{{ $job->title }}</td>
                            <td class="px-6 py-4 text-sm">{{ $job->company->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm">{{ $job->applications_count }}</td>
                        </tr>
                    @endforeach
                </x-dashboard-table>

                <x-dashboard-table :title="__('dashboard.top_converting_jobs')" :headers="[__('dashboard.job_title'), __('dashboard.views'), __('dashboard.applications'), __('dashboard.conversion_rate')]">
                    @foreach($analytics['topConvertingJobs'] as $job)
                        <tr>
                            <td class="px-6 py-4 text-sm">{{ $job->title }}</td>
                            <td class="px-6 py-4 text-sm">{{ $job->views }}</td>
                            <td class="px-6 py-4 text-sm">{{ $job->applications_count }}</td>
                            <td class="px-6 py-4 text-sm">
                                {{ $job->views > 0 ? number_format(($job->applications_count / $job->views) * 100, 1) . '%' : '0%' }}
                            </td>
                        </tr>
                    @endforeach
                </x-dashboard-table>

            @elseif(isset($analytics['companyJobs']))
                {{-- Company Owner Dashboard --}}
                <div class="grid grid-cols-2 gap-6">
                    <x-dashboard-card title="Company Job Postings" :value="$analytics['companyJobs']" />

                    <x-dashboard-card title="Applications to Company Jobs" :value="$analytics['companyApplications']" />
                </div>



                <x-dashboard-table title="Most Applied Jobs (Company)" :headers="['Job Title', 'Applications']">
                    @foreach($analytics['mostAppliedJobs'] as $job)
                        <tr>
                            <td class="px-6 py-4 text-sm">{{ $job->title }}</td>
                            <td class="px-6 py-4 text-sm">{{ $job->applications_count }}</td>
                        </tr>
                    @endforeach
                </x-dashboard-table>


                {{-- Top Converting Job Posts --}}
                <x-dashboard-table title="Top Converting Job Posts (Company)" :headers="['Job Title', 'Views', 'Applications', 'Conversion Rate']">
                    @foreach($analytics['topConvertingJobs'] as $job)
                        <tr>
                            <td class="px-6 py-4 text-sm">{{ $job->title }}</td>
                            <td class="px-6 py-4 text-sm">{{ $job->views }}</td>
                            <td class="px-6 py-4 text-sm">{{ $job->applications_count }}</td>
                            <td class="px-6 py-4 text-sm">
                                {{ $job->views > 0 ? number_format(($job->applications_count / $job->views) * 100, 1) . '%' : '0%' }}
                            </td>
                        </tr>
                    @endforeach
                </x-dashboard-table>

            @else
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <p class="text-gray-500 text-sm">No analytics data available.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>