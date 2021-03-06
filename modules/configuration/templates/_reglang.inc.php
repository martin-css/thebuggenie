<table style="clear: both; width: 700px; margin-top: 5px;" class="padded_table" cellpadding=0 cellspacing=0>
	<tr>
		<td style="width: 200px;"><label for="language"><?php echo __('Interface language'); ?></label></td>
		<td style="width: auto;">
			<select name="<?php echo TBGSettings::SETTING_DEFAULT_LANGUAGE; ?>" id="language" style="width: 300px;"<?php if ($access_level != TBGSettings::ACCESS_FULL): ?> disabled<?php endif; ?>>
			<?php foreach ($languages as $lang_code => $lang_desc): ?>
				<option value="<?php echo $lang_code; ?>" <?php if (TBGSettings::getLanguage() == $lang_code): ?> selected<?php endif; ?>><?php echo $lang_desc; ?></option>
			<?php endforeach; ?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="config_explanation" colspan="2"><?php echo __('This is the language that will be used in The Bug Genie. Depending on other settings, users may change the language displayed to them.'); ?></td>
	</tr>
	<tr>
		<td><label for="charset"><?php echo __('Charset'); ?></label></td>
		<td>
			<input type="text" name="<?php echo TBGSettings::SETTING_DEFAULT_CHARSET; ?>" id="charset" value="<?php echo TBGSettings::getCharset(); ?>" style="width: 150px;"<?php if ($access_level != TBGSettings::ACCESS_FULL): ?> disabled<?php endif; ?>>
			<span class="config_explanation"><?php echo __('Current character set is %charset%', array('%charset%' => '<b>' . TBGContext::getI18n()->getLangCharset() . '</b>')); ?></span>
		</td>
	</tr>
	<tr>
		<td class="config_explanation" colspan="2"><?php echo __('What charset to use for the selected language - leave blank to use the charset specified in the language file'); ?></td>
	</tr>
	<tr>
		<td><label for="server_timezone"><?php echo __('Server timezone'); ?></label></td>
		<td>
			<select name="<?php echo TBGSettings::SETTING_SERVER_TIMEZONE; ?>" id="server_timezone" style=""<?php if ($access_level != TBGSettings::ACCESS_FULL): ?> disabled<?php endif; ?>>
				<option value=""<?php if (TBGSettings::getServerTimezoneIdentifier() == ''): ?> selected<?php endif; ?>><?php echo __('Not set'); ?></option>
				<?php foreach ($timezones as $timezone => $description): ?>
					<option value="<?php echo $timezone; ?>"<?php if (TBGSettings::getServerTimezoneIdentifier() == $timezone): ?> selected<?php endif; ?>><?php echo $description; ?></option>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="config_explanation" colspan="2">
			<?php echo __('The timezone for the server hosting The Bug Genie. Make sure this is the same as the timezone the server is running in - this is not necessarily the same as your own timezone!'); ?><br>
			<?php echo __('The time is now: %time%', array('%time%' => tbg_formatTime(time(), 1, true))); ?>
		</td>
	</tr>
</table>