/**
 * Created by jason on 6/30/16.
 *
 * Created converter for jquery and bootstrap tooltip conflict.
 * this converter should be place between jquery and bootstrap.
 * Jquery should be called first then bootstrap.
 */

$.widget.bridge('uibutton', $.ui.button);
$.widget.bridge('uitooltip', $.ui.tooltip);
