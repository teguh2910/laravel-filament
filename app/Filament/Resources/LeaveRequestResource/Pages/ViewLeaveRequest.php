<?php

namespace App\Filament\Resources\LeaveRequestResource\Pages;

use App\Filament\Resources\LeaveRequestResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewLeaveRequest extends ViewRecord
{
    use  \EightyNine\Approvals\Traits\HasApprovalHeaderActions;
    protected static string $resource = LeaveRequestResource::class;

    protected function getOnCompletionAction(): Action
    {
        return Action::make("Done")
            ->color("success")
            // Do not use the visible method, since it is being used internally to show this action if the approval flow has been completed.
            // Using the hidden method add your condition to prevent the action from being performed more than once
            ->hidden(function () {
                return $this->record->approvalStatus->status !== "APPROVED";
            });
    }
}
