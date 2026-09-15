import Dialog from "@mui/material/Dialog";
import DialogActions from "@mui/material/DialogActions";
import DialogTitle from "@mui/material/DialogTitle";
import Button from "@mui/material/Button";
import IconButton from "@mui/material/IconButton";
import EditIcon from "@mui/icons-material/Edit";
import Tooltip from "@mui/material/Tooltip";
import { useState, type ChangeEvent } from "react";
import OriginaltextDialogContent from "./OriginaltextDialogContent";
import { type OriginalText, type OriginalTextResponse } from "../types/types";
import { updateOriginaltext } from "../api/originaltextapi";
import { useMutation, useQueryClient } from "@tanstack/react-query";

type FormProps = {
  originaltextdata: OriginalTextResponse;
};

const toNumber = (value: unknown, fallback = 0) => {
  const parsed = Number(value);
  return Number.isFinite(parsed) ? parsed : fallback;
};

function EditOriginaltext({ originaltextdata }: FormProps) {
  const [open, setOpen] = useState(false);

  const [originaltext, setOriginalText] = useState<OriginalText>({
    idorigtext: toNumber(originaltextdata.idorigtext ?? 0),
    origtextauthor: originaltextdata.origtextauthor ?? "",
    origtexttitle: originaltextdata.origtexttitle ?? "",
    origtexttext: originaltextdata.origtexttext ?? "",
    origtextimage: originaltextdata.origtextimage ?? "",
    origtextcentury: toNumber(originaltextdata.origtextcentury ?? 0),
    hits: toNumber(originaltextdata.hits ?? 0),
    idplace: toNumber(originaltextdata.idplace ?? 0),
    idlanguage: toNumber(originaltextdata.idlanguage ?? 0),
    idauthor: toNumber(originaltextdata.idauthor ?? 0),
  });

  const handleClickOpen = () => {
    setOriginalText({
      idorigtext: toNumber(originaltextdata.idorigtext ?? 0),
      origtextauthor: originaltextdata.origtextauthor ?? "",
      origtexttitle: originaltextdata.origtexttitle ?? "",
      origtexttext: originaltextdata.origtexttext ?? "",
      origtextimage: originaltextdata.origtextimage ?? "",
      origtextcentury: toNumber(originaltextdata.origtextcentury ?? 0),
      hits: toNumber(originaltextdata.hits ?? 0),
      idplace: toNumber(originaltextdata.idplace ?? 0),
      idlanguage: toNumber(originaltextdata.idlanguage ?? 0),
      idauthor: toNumber(originaltextdata.idauthor ?? 0),
    });
    setOpen(true);
  };

  const numericFields = new Set([
    "idorigtext",
    "origtextcentury",
    "idplace",
    "idlanguage",
    "idauthor",
  ]);

  const handleChange = (event: ChangeEvent<HTMLInputElement>) => {
    const { name, value } = event.target;
    setOriginalText((prev) => ({
      ...prev,
      [name]: numericFields.has(name) ? Number(value) : value,
    }));
  };

  const handleClose = () => {
    setOpen(false);
  };

  const handleSave = () => {
    mutate(originaltext);
    setOriginalText({
      idorigtext: 0,
      origtextauthor: "",
      origtexttitle: "",
      origtexttext: "",
      origtextimage: "",
      origtextcentury: 0,
      idplace: 0,
      idlanguage: 0,
      idauthor: 0,
    });
    setOpen(false);
  };
  // Get query client
  const queryClient = useQueryClient();
  // Use useMutation hook
  const { mutate } = useMutation({
    mutationFn: updateOriginaltext,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["originaltexts"] });
    },
    onError: (err) => {
      console.error(err);
    },
  });

  return (
    <>
      <Tooltip title="Edit Original Text">
        <IconButton aria-label="edit" size="small" onClick={handleClickOpen}>
          <EditIcon fontSize="small" />
        </IconButton>
      </Tooltip>
      <Dialog open={open} onClose={handleClose}>
        <DialogTitle>Edit Original Text</DialogTitle>
        <OriginaltextDialogContent
          originaltext={originaltext}
          handleChange={handleChange}
        />
        <DialogActions>
          <Button onClick={handleClose}>Cancel</Button>
          <Button onClick={handleSave}>Save</Button>
        </DialogActions>
      </Dialog>
    </>
  );
}

export default EditOriginaltext;
