#!/bin/bash

# Used colors
GREEN='\033[0;32m'
ORANGE='\033[0;33m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Help
if [ "$1" == "--help" ] || [ -z "$1" ]
then
  echo "Execution of processes in async mode for tests"
  echo
  echo -e ${ORANGE}Usage:${NC}
  printf '  ./pprocess [--command="<your command>"] [--processes=<processes count>]\n'
  printf '  cat commands.txt | ./pprocess [--processes=<processes count>]\n'
  echo
  echo -e ${ORANGE}Example:${NC}
  printf '  ./pprocess --command="( sleep 1 ; exit 0 )" --processes=10\n'
  echo "  printf '( sleep 1 ; exit 0 )\n( sleep 1 ; exit 1 )\n' | ./pprocess --stdin --processes=2"
  echo
  echo -e ${ORANGE}Options:${NC}
  echo -e "${GREEN}  --command   Tested command${NC}"
  echo -e "${GREEN}  --stdin     Read commands from stdin instead of --command${NC}"
  echo -e "${GREEN}  --processes Count of background processes. Default is 3 for --command option and 1 for --stdin.${NC}"
  echo
  exit 1
fi

printf '\n\n'>&2

for i in "$@"
do
  case $i in
    --command=*)
    COMMAND="${i#*=}"
    shift # past argument=value
    ;;
    --stdin)
    STDIN=YES
    shift # past argument with no value
    ;;
    --processes=*)
    PROCESSES="${i#*=}"
    shift # past argument=value
    ;;
    *)
          # unknown option
    ;;
  esac
done


# Defaults
if [ "$STDIN" == "YES" ] && [ -z "$PROCESSES" ]
then
  PROCESSES=1
elif [ "$STDIN" != "YES" ] && [ -z "$PROCESSES" ]
then
  PROCESSES=3
fi

if [ -z "$COMMAND" ] && [ -z "$STDIN" ]
then
  STDIN=YES
fi

# PIDs of started processes in background
pids=()

# Actual results of background processes
results=()

# Expected results of background processes (zeros)
expects=()

# Run processes in background and redirect output into stderr
if [ "$STDIN" == "YES" ]
then
  while read COMMAND
  do
    for i in $(seq $PROCESSES)
    do
      eval $COMMAND 1>&2 & pids+=($!) ; echo -e ${YELLOW}'>>>' Process ${pids[i-1]} started: $COMMAND${NC} 1>&2
    done
  done < "${1:-/dev/stdin}"
else
  for i in $(seq $PROCESSES)
  do
    eval $COMMAND 1>&2 & pids+=($!) ; echo -e ${YELLOW}'>>>' Process ${pids[i-1]} started${NC} 1>&2
  done
fi

# Waiting for every background process and store results into $results
for pid in "${pids[@]}"
do
  wait $pid
  results+=($?)
  expects+=(0)
  echo -e "${ORANGE}"'<<<' Process $pid finished ${NC} 1>&2
done

printf '\n'>&2

# Prepare results for comparison
result=`( IFS=$', '; echo "${results[*]}" )`
expect=`( IFS=$', '; echo "${expects[*]}" )`

# Return error code if actual results are not matched with expected
if [ "$result" != "$expect" ]
then
  exit 1
fi
