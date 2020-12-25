<v-activity-card>
    <template #header>
        <span class="font-semibold">Replied to</span> 
        <a href="{{$activity->subject->thread->path()}}">{{$activity->subject->thread->title}}</a>
    </template>
    <template #body>
        <p>{{$activity->subject->body}}</p>
    </template>
</v-activity-card>