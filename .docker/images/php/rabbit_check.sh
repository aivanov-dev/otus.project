((count = 100))                            # Maximum number to try.
while [[ $count -ne 0 ]] ; do
    nc -zw10 rabbit 5672                       # Try once.
    rc=$?
    if [[ $rc -eq 0 ]] ; then
        ((count = 1))                      # If okay, flag to exit loop.
    fi
    ((count = count - 1))                  # So we don't go forever.
    sleep 1
done

if [[ $rc -eq 0 ]] ; then                  # Make final determination.
    echo 'The rabbit is ready.'
else
    echo 'Timeout.'
fi
